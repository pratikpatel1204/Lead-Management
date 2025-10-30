<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    
    public function employee_list()
    {
        $employees = User::with('roles')->latest()->get();
        return view('admin.employees.list', compact('employees'));
    }
    public function create_employee()
    {

        $roles = Role::where('name', '!=', 'super admin')->get();
        return view('admin.employees.create', compact('roles'));
    }
    public function employee_store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
            'role'    => 'required|exists:roles,name',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/profile/'; // folder path
            $file->move(public_path($path), $filename);

            $imagePath = $path . $filename;
        }

        // Create Employee
        $employee = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'profile_image' => $imagePath,
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
        return view('admin.employees.edit', compact('employee', 'roles'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'role' => 'required|exists:roles,name',
            'password' => 'nullable|min:6',
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

        if ($request->filled('password')) {
            $employee->password = bcrypt($request->password);
        }

        // Profile image upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/profile/';
            $file->move(public_path($path), $filename);

            if ($employee->profile_image && file_exists(public_path($employee->profile_image))) {
                unlink(public_path($employee->profile_image));
            }

            $employee->profile_image = $path . $filename;
        }

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
}
