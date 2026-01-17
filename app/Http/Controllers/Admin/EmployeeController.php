<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\LeadFieldOrder;
use App\Models\State;
use App\Models\TemplateMaster;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    
    public function employee_list()
    {
        $employees = User::with('roles')->latest()->get();
        //Table Order
        $fieldsorder = LeadFieldOrder::where('emp_id', auth()->id())
            ->where('template_name', 'lead_master')
            ->orderBy('order_number')
            ->pluck('field_name')
            ->toArray();

        //Table Field All
        $tablefield = TemplateMaster::with(['field', 'field.templateData'])
            ->whereIn('name', ['Lead Master', 'Lead Meetings'])
            ->orderBy('order_no', 'asc')
            ->get();

        return view('admin.employees.list', compact('employees', 'fieldsorder', 'tablefield'));
    }
    public function create_employee()
    {

        $roles = Role::where('name', '!=', 'super admin')->get();
        $states = State::get();
        return view('admin.employees.create', compact('roles', 'states'));
    }
    public function employee_store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|string|max:50|unique:users,employee_id',

            'name' => 'required|string|max:255',

            'role' => 'required|string|exists:roles,name',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|min:6',

            'personal_email' => 'nullable|email',

            'mobile' => 'required|digits:10',

            'whatsapp_number' => 'required|digits:10',

            'address' => 'required|string',

            'state_id' => 'required|exists:states,id',

            'city_id' => 'required|exists:cities,id',

            'pincode' => 'required|digits:6',

            'reporting_manager' => 'required|exists:users,id',

            'pan_number' => 'nullable|string|max:10',
            'pan_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'aadhar_number' => 'nullable|digits:12',
            'aadhar_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'status' => 'nullable|boolean',
        ]);

        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/profile/'; // folder path
            $file->move(public_path($path), $filename);
            $profileImagePath = $path . $filename;
        }

        $panImagePath = null;
        if ($request->hasFile('pan_image')) {
            $file = $request->file('pan_image');
            $filename = 'pan_'.time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/profile/'; // folder path
            $file->move(public_path($path), $filename);
            $panImagePath = $path . $filename;
        }       

        $aadharImagePath = null;       
        if ($request->hasFile('aadhar_image')) {
            $file = $request->file('aadhar_image');
            $filename = 'aadhar_'.time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/profile/'; // folder path
            $file->move(public_path($path), $filename);
            $aadharImagePath = $path . $filename;
        }

        // Create Employee
        $employee = User::create([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'show_password' => $request->password,

            'personal_email' => $request->personal_email,
            'mobile' => $request->mobile,
            'whatsapp_number' => $request->whatsapp_number,
            'address' => $request->address,

            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'pincode' => $request->pincode,

            'reporting_manager' => $request->reporting_manager,

            'pan_number' => $request->pan_number,
            'pan_image' => $panImagePath,

            'aadhar_number' => $request->aadhar_number,
            'aadhar_image' => $aadharImagePath,

            'profile_image' => $profileImagePath,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        // Assign Role
        $employee->assignRole($request->role);

        return response()->json([
            'status'  => true,
            'message' => 'Employee created successfully',
        ]);
    }

    public function employee_edit(string $id)
    {
        $employee = User::findOrFail($id);
        if ($employee->hasRole('super admin')) {
            return redirect()->back()->with('error', 'You cannot edit the Super Admin');
        }
        $roles = Role::where('name', '!=', 'Super Admin')->get();
        $states = State::get();
        return view('admin.employees.edit', compact('employee', 'roles', 'states'));
    }

    public function employee_update(Request $request)
    {
        $employee = User::findOrFail($request->id);

        // Block updating Super Admin
        if ($employee->hasRole('Super Admin')) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot update the Super Admin!'
            ], 403);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|string|max:50|unique:users,employee_id,' . $employee->id,
            'name' => 'required|string|max:255',
            'role' => 'required|exists:roles,name',
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'password' => 'nullable|min:6',
            'personal_email' => 'nullable|email',
            'mobile' => 'required|digits:10',
            'whatsapp_number' => 'nullable|digits:10',
            'address' => 'required|string',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'pincode' => 'required|digits:6',
            'reporting_manager' => 'nullable|exists:users,id',
            'pan_number' => 'nullable|string|max:10',
            'pan_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'aadhar_number' => 'nullable|digits:12',
            'aadhar_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Update fields
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->status = $request->has('status') ? 1 : 0;
        if ($request->filled('password')) {
            $employee->password = bcrypt($request->password);
            $employee->show_password = $request->password;
        }

        // Profile image upload
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/profile/';
            $file->move(public_path($path), $filename);

            if ($employee->profile_image && file_exists(public_path($employee->profile_image))) {
                unlink(public_path($employee->profile_image));
            }
            $employee->profile_image = $path . $filename;
        }
        // PAN image
        if ($request->hasFile('pan_image')) {
            $file = $request->file('pan_image');
            $filename = 'pan' . time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/profile/';
            $file->move(public_path($path), $filename);

            if ($employee->pan_image && file_exists(public_path($employee->pan_image))) {
                unlink(public_path($employee->pan_image));
            }

            $employee->pan_image = $path . $filename;
        }

        // Aadhar image
        if ($request->hasFile('aadhar_image')) {
            $file = $request->file('aadhar_image');
            $filename = 'aadhar' . time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/profile/';
            $file->move(public_path($path), $filename);

            if ($employee->aadhar_image && file_exists(public_path($employee->aadhar_image))) {
                unlink(public_path($employee->aadhar_image));
            }

            $employee->aadhar_image = $path . $filename;
        }
        $employee->employee_id = $request->employee_id;
        $employee->personal_email = $request->personal_email;
        $employee->mobile = $request->mobile;
        $employee->whatsapp_number = $request->whatsapp_number;
        $employee->address = $request->address;
        $employee->state_id = $request->state_id;
        $employee->city_id = $request->city_id;
        $employee->pincode = $request->pincode;
        $employee->reporting_manager = $request->reporting_manager;
        $employee->aadhar_number = $request->aadhar_number;
        $employee->pan_number = $request->pan_number;
        $employee->fcm_token = $request->fcm_token;
        $employee->save();
        $employee->syncRoles([$request->role]);

        return response()->json([
            'status' => true,
            'message' => 'Employee updated successfully!'
        ]);
    }


    public function employee_delete($id)
    {
        $employee = User::findOrFail($id);

        if ($employee->hasRole('Super Admin')) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot delete the Super Admin!'
            ], 403);
        }

        // Delete profile image if exists
        if ($employee->profile_image && file_exists(public_path($employee->profile_image))) {
            unlink(public_path($employee->profile_image));
        }

        $employee->delete();

        return response()->json([
            'status' => true,
            'message' => 'Employee deleted successfully!'
        ]);
    }
    public function employee_update_status(Request $request)
    {
        try {
            $employee = User::find($request->id);

            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employee not found.'
                ], 404);
            }

            $employee->status = $request->status;
            $employee->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
    public function getCities($id)
    {
        return City::where('state_id', $id)->orderBy('name', 'asc')->get();
    }
    public function getReportingManagers($roleId){
        return User::where('status', 1)
            ->where(function ($query) use ($roleId) {
                $query->where('role', $roleId)
                    ->orWhereIn('role', ['super admin', 'admin']);
            })
            ->select('id', 'name', 'role')
            ->orderBy('name')
            ->get();
    }
    public function get_lead_serialize(Request $request)
    {
        $emp = User::findOrFail($request->id);

        //Table Order
        $fieldsorder = LeadFieldOrder::where('emp_id', $emp->id)
            ->where('template_name', 'lead_master')
            ->orderBy('order_number')
            ->pluck('field_name')
            ->toArray();

        //Table Field All
        $tablefield = TemplateMaster::with(['field', 'field.templateData'])
            ->whereIn('name', ['Lead Master', 'Lead Meetings'])
            ->orderBy('order_no', 'asc')
            ->get();

        $html = view('admin.partials.serialize_lead', compact('emp', 'fieldsorder', 'tablefield'))->render();
        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }
    public function lead_field_order_save(Request $request)
    {
        $request->validate([
            'field_order' => 'required|string'
        ]);

        // Convert CSV to array
        $fields = array_values(array_filter(
            explode(',', $request->field_order)
        ));

        if (empty($fields)) {
            return response()->json([
                'success' => false,
                'message' => 'No fields found'
            ], 422);
        }

        DB::beginTransaction();

        try {

            // Delete old order for this employee & template
            LeadFieldOrder::where('emp_id', $request->emp_id)
                ->where('template_name', 'lead_master')
                ->delete();

            // Insert new order
            foreach ($fields as $index => $fieldName) {
                LeadFieldOrder::create([
                    'emp_id' => $request->emp_id,
                    'template_name' => 'lead_master',
                    'field_name' => $fieldName,
                    'order_number' => $index + 1,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Field order saved successfully'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while saving'
            ], 500);
        }
    }
}
