<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\LeadFieldOrder;
use App\Models\Meeting;
use App\Models\TemplateData;
use App\Models\TemplateMaster;
use App\Models\LoginHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator;

class LeadMasterController extends Controller
{
    public function lead_master()
    {
        //Create Lead
        $templates = TemplateMaster::with(['field', 'field.templateData'])
            ->where('name', 'Lead Master')
            ->orderBy('order_no', 'asc')
            ->get();
            
        //Create Lead Meetings Meeting
        $leadmeetings = TemplateMaster::with(['field', 'field.templateData'])
            ->where('name', 'Lead Meetings')
            ->orderBy('order_no', 'asc')
            ->get();
        
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

        $dateExpression = "
            CASE
                WHEN value LIKE '%/%/%' THEN STR_TO_DATE(value, '%m/%d/%Y')
                WHEN value LIKE '%/%/%' THEN STR_TO_DATE(value, '%d/%m/%Y')
                WHEN value LIKE '%-%-%' THEN STR_TO_DATE(value, '%Y/%m/%d')
                WHEN value LIKE '%/%/%' THEN STR_TO_DATE(value, '%m-%d-%Y')
                WHEN value LIKE '%/%/%' THEN STR_TO_DATE(value, '%d-%m-%Y')
                WHEN value LIKE '%-%-%' THEN STR_TO_DATE(value, '%Y-%m-%d')
                ELSE NULL
            END
        ";

        $baseMeetingQuery = Meeting::query()
            ->where('label', 'Next Meeting Date')
            ->whereNotNull('value')
            ->where('value', '!=', '0000-00-00')
            ->empScope();

        $today = now()->toDateString();

        // 1️⃣ Get paginated meetings
        $meetingsid = $baseMeetingQuery
            ->empScope()
            ->select('*')
            ->selectRaw("$dateExpression as meeting_date")
            ->whereRaw("$dateExpression IS NOT NULL")
            ->whereRaw("$dateExpression <= ?", [$today])
            ->orderByRaw("
                CASE 
                    WHEN $dateExpression IS NULL THEN 2
                    WHEN $dateExpression >= ? THEN 0
                    ELSE 1
                END,
                $dateExpression DESC
            ", [$today])
            ->distinct('form_group_id')
            ->paginate(25)
            ->withQueryString();  // keeps ?page=x in links

        $meetingsidPluck = $meetingsid->pluck('meeting_group', 'form_group_id');
        $formGroupIds = $meetingsidPluck->keys();
        $meeting_Ids  = $meetingsidPluck->values();

        // 2️⃣ Load lead data
        $leaddata = TemplateData::with('field')
            ->where('template_name', 'Lead Master')
            ->empScope()
            ->whereIn('form_group_id', $formGroupIds)
            ->get()
            ->groupBy('form_group_id');

        // 3️⃣ Load latest meetings
        $latestMeetings = Meeting::query()
            ->empScope()
            ->whereIn('meeting_group', $meeting_Ids)
            ->get()
            ->groupBy('form_group_id');

        // 4️⃣ Count meetings
        $meetingCounts = Meeting::query()
            ->empScope()
            ->whereIn('form_group_id', $formGroupIds)
            ->select('form_group_id')
            ->selectRaw('COUNT(DISTINCT meeting_group) as total_meetings')
            ->groupBy('form_group_id')
            ->pluck('total_meetings', 'form_group_id');

        // 5️⃣ Merge data WITH pagination
        $finalData = $meetingsid->through(function ($meeting) use ($leaddata, $latestMeetings, $meetingCounts) {
            $groupId = $meeting->form_group_id;
            return [
                'form_group_id' => $groupId,
                'lead'          => $leaddata[$groupId] ?? collect(),
                'meeting'       => $latestMeetings[$groupId] ?? collect(),
                'meeting_count' => $meetingCounts[$groupId] ?? 0,
            ];
        });

        $users = User::where('role', '!=', 'super admin')->get();

        $empId = auth()->user()->id;
        $isPrivileged = in_array(auth()->user()->role, ['admin', 'super admin']);
        $applyEmpFilter = !$isPrivileged;

        $all_leads = TemplateData::where('template_name', 'Lead Master')
            ->empScope()
            ->distinct('form_group_id')
            ->count('form_group_id');

        $globle_leads = TemplateData::where('template_name', 'Lead Master')
            ->where('field_value', 'global')
            ->empScope()
            ->distinct('form_group_id')
            ->count('form_group_id');

        $private_leads = TemplateData::where('template_name', 'Lead Master')
            ->where('field_value', 'private')
            ->empScope()
            ->distinct('form_group_id')
            ->count('form_group_id');

        $leadStats = TemplateData::query()
            ->from('template_data as td')
            ->where('td.template_name', 'Lead Master')
            ->empScope()

            // Latest meeting per lead
            ->leftJoinSub(
                Meeting::query()
                    ->select('form_group_id', DB::raw('MAX(id) as max_id'))
                    ->where('label', 'Meeting Status')
                    ->empScope()
                    ->groupBy('form_group_id'),
                'lm',
                fn($join) => $join->on('td.form_group_id', '=', 'lm.form_group_id')
            )

            // Join latest meeting row
            ->leftJoin('meetings as m', 'm.id', '=', 'lm.max_id')

            ->selectRaw('
                COUNT(DISTINCT td.form_group_id) as total_leads,

                COUNT(DISTINCT CASE 
                    WHEN m.value = "Closed" 
                    THEN td.form_group_id 
                END) as closed_leads,

                COUNT(DISTINCT CASE 
                    WHEN m.value IS NOT NULL
                    AND m.value != "Closed"
                    AND m.value != "NULL"
                    THEN td.form_group_id 
                END) as active_leads,

                COUNT(DISTINCT CASE 
                    WHEN m.value IS NULL
                    OR m.value = "NULL"
                    THEN td.form_group_id 
                END) as null_leads
            ')
            ->first();

        $total_Closed = (int) optional($leadStats)->closed_leads;
        $total_active = (int) optional($leadStats)->active_leads + (int) optional($leadStats)->null_leads;

        $labels = Field::with('dropdowns')->where('name', 'Labels')->first()?->dropdowns->pluck('value') ?? collect();
        $areas = Field::with('dropdowns')->where('name', 'Area')->first()?->dropdowns->pluck('value') ?? collect();
        $projectTypes = Field::with('dropdowns')->where('name', 'Project Type')->first()?->dropdowns->pluck('value') ?? collect();
        $leadSources = Field::with('dropdowns')->where('name', 'Lead Source')->first()?->dropdowns->pluck('value') ?? collect();
        $spProducts = Field::with('dropdowns')->where('name', 'SP Focused Product')->first()?->dropdowns->pluck('value') ?? collect();
        $siteStages = Field::with('dropdowns')->where('name', 'Site Stage')->first()?->dropdowns->pluck('value') ?? collect();
        $customerTypes = Field::with('dropdowns')->where('name', 'Customer Type')->first()?->dropdowns->pluck('value') ?? collect();
        $leadTypes = Field::with('dropdowns')->where('name', 'Lead Type')->first()?->dropdowns->pluck('value') ?? collect();


        return view('admin.lead.list', compact(
            'templates',
            'leadmeetings',
            'fieldsorder',
            'tablefield',
            'leaddata',
            'finalData',
            'all_leads',
            'globle_leads',
            'private_leads',
            'total_Closed',
            'total_active',
            'users',
            'labels',
            'areas',
            'projectTypes',
            'leadSources',
            'spProducts',
            'siteStages',
            'customerTypes',
            'leadTypes'
        ));
    }

    public function lead_field_order_save(Request $request){
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
            LeadFieldOrder::where('emp_id', auth()->id())
                ->where('template_name', 'lead_master')
                ->delete();

            // Insert new order
            foreach ($fields as $index => $fieldName) {
                LeadFieldOrder::create([
                    'emp_id' => auth()->id(),
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
    public function lead_master_store(Request $request)
    {
        $templates = TemplateMaster::with('field')
            ->where('name', 'Lead Master')
            ->orderBy('order_no')
            ->get();

        $rules = [];
        $input = $request->all();
        $fieldMap = [];
        $siteNameValue = null;

        foreach ($templates as $t) {
            $field = $t->field;
            $fieldId = $field->id;
            $slug  = Str::slug($field->name, '_');
            $fieldMap[$fieldId] = $slug;
            $rules[$slug] = $field->validation_type ?? 'nullable';
            if ($request->has($field->id)) {
                $input[$slug] = $request->input($field->id);
            }
            if ($field->name === 'Site Name') {
                $siteNameValue = $request->input($field->id);
            }
        }
        $validator = Validator::make($input, $rules);
   
        $validator->after(function ($validator) use ($siteNameValue) {

            if (!$siteNameValue) {
                return;
            }

            $exists = TemplateData::where('template_name', 'Lead Master')
                ->where('field_name', 'Site Name')
                ->where('field_value', $siteNameValue)
                ->exists();

            if ($exists) {
                $validator->errors()->add(
                    'site_name',
                    'Site Name already exists'
                );
            }
        });
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $validated = $validator->validated();
        do {
            $formGroupId = 'RF' . rand(10000, 99999);
            $exists = TemplateData::where('form_group_id', $formGroupId)->exists();
        } while ($exists);

        foreach ($fieldMap as $fieldId => $slug) {

            $field = Field::find($fieldId);
            if (!$field) continue;

            $value = $validated[$slug] ?? null;
            if ($field->type === 'file') {
                if ($request->hasFile($fieldId)) {
                    $file = $request->file($fieldId);
                    $filename = $formGroupId . "_" . $slug . "_" . time() . "." . $file->getClientOriginalExtension();
                    $path = 'form_data/';
                    $file->move(public_path($path), $filename);
                    $value = $path . $filename;
                }
            }
            TemplateData::create([
                'form_group_id' => $formGroupId,
                'template_name' => 'Lead Master',
                'emp_id'      => $request->lead_emp_id ?? Auth::user()->id,
                'field_id'      => $fieldId,
                'field_name'    => $field->name,
                'field_value'   => $value,
            ]);
        }
        return response()->json([
            'status'  => true,
            'message' => 'Lead saved successfully!'
        ]);
    }
    public function lead_master_edit($formGroupId)
    {
        $templates = TemplateMaster::with('field')
            ->where('name', 'Lead Master')
            ->orderBy('order_no', 'asc')
            ->get();

        $leadData = TemplateData::with('field')
            ->where('form_group_id', $formGroupId)
            ->get()
            ->keyBy('field_id'); // 🔥 IMPORTANT

        $templateName = $leadData->first()->template_name ?? 'Template';
        $empId = $leadData->first()->emp_id ?? '';
        $users = User::where('role', '!=', 'super admin')->get();

        return view(
            'admin.lead.edit',
            compact('templates', 'leadData', 'templateName', 'formGroupId', 'users', 'empId')
        );
    }

    public function lead_master_update(Request $request)
    {
        $formGroupId = $request->form_group_id;

        // Get template fields
        $templates = TemplateMaster::with('field')
            ->where('name', 'Lead Master')
            ->orderBy('order_no')
            ->get();

        $rules = [];
        $input = [];
        $fieldMap = [];

        /** -----------------------------
         * BUILD VALIDATION RULES
         * ----------------------------- */
        foreach ($templates as $t) {

            if (!$t->field) continue;

            $field = $t->field;
            $fieldId = $field->id;
            $slug = Str::slug($field->name, '_');

            $fieldMap[$fieldId] = $slug;

            $rules[$slug] = $field->validation_type ?? 'nullable';

            if ($request->has($fieldId)) {
                $input[$slug] = $request->input($fieldId);
            }
        }

        // VALIDATE
        $validated = Validator::make($input, $rules)->validate();

        /** -----------------------------
         * SAVE / UPDATE DATA
         * ----------------------------- */
        foreach ($fieldMap as $fieldId => $slug) {

            $field = Field::find($fieldId);
            if (!$field) continue;

            $value = $validated[$slug] ?? null;

            /** -----------------------------
             * FILE HANDLING
             * ----------------------------- */
            if ($field->type === 'file') {

                if ($request->hasFile($fieldId)) {

                    $file = $request->file($fieldId);
                    $filename = $formGroupId . "_" . $slug . "_" . time() . "." . $file->getClientOriginalExtension();
                    $path = 'form_data/';
                    $file->move(public_path($path), $filename);

                    // Remove old file if exists
                    $old = TemplateData::where('form_group_id', $formGroupId)
                        ->where('field_id', $fieldId)
                        ->first();

                    if ($old && $old->field_value && file_exists(public_path($old->field_value))) {
                        @unlink(public_path($old->field_value));
                    }

                    $value = $path . $filename;
                } else {
                    continue; // no file uploaded
                }
            }

            /** -----------------------------
             * CREATE OR UPDATE FIELD
             * ----------------------------- */
            TemplateData::updateOrCreate(
                [
                    'form_group_id' => $formGroupId,
                    'field_id'      => $fieldId
                ],
                [
                    'template_name' => 'Lead Master',
                    'field_name'    => $field->name,
                    'field_value'   => $value,
                    'emp_id'        => $request->lead_emp_id,
                ]
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Lead saved successfully!'
        ]);
    }

    public function lead_bulkDelete(Request $request)
    {
        $groupIds = $request->group_ids;

        if (empty($groupIds)) {
            return response()->json([
                'success' => false,
                'message' => 'No records selected'
            ], 400);
        }

        // Delete template data
        TemplateData::whereIn('form_group_id', $groupIds)->delete();

        // Delete meetings related to those group IDs
        Meeting::whereIn('form_group_id', $groupIds)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Form groups deleted successfully!'
        ]);
    }

    public function lead_master_get_data($groupId)
    {
        $records = TemplateData::with('field')
            ->where('form_group_id', $groupId)
            ->empScope()
            ->get();

        $meetings = Meeting::where('form_group_id', $groupId)
            ->empScope()
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('meeting_group');

        $isClosed = Meeting::where('form_group_id', $groupId)
            ->where('label', 'Meeting Status')
            ->where('value', 'Closed')
            ->exists();

        $isPrivileged = auth()->check() &&
            in_array(auth()->user()->role, ['admin', 'super admin']);

        $showForm = $isPrivileged || !$isClosed;

        return response()->json([
            'status'   => true,
            'data' => $records,
            'meetings' => $meetings,
            'showForm' => $showForm
        ]);
    }

    public function meetings_store(Request $request)
    {
        // Detect platform
        $isMobile = preg_match(
            '/Mobile|Android|iPhone|iPad|iPod/i',
            $request->header('User-Agent')
        );

        $platform = $isMobile ? 'mobile' : 'web';

        // Auto device identifier
        if ($platform === 'web') {
            // 🌐 Web → IP address
            $deviceIdentifier = $request->ip();
        } else {
            // 📱 Mobile → device id header OR fallback IP
            $deviceIdentifier =
                $request->header('X-Device-ID') ??
                $request->ip();
        }
       
        $formGroupId = $request->form_group_id;
        $templates = TemplateMaster::with('field')->where('name', 'Lead Meetings')->orderBy('order_no')->get();

        $rules = [];
        $input = [];
        $fieldMap = [];

        foreach ($templates as $t) {
            if (!$t->field) continue;

            $field = $t->field;
            $fieldId = $field->id;
            $slug = Str::slug($field->name, '_');

            $fieldMap[$fieldId] = $slug;
            $rules[$slug] = $field->validation_type ?? 'nullable';

            if ($request->has($fieldId)) {
                $input[$slug] = $request->input($fieldId);
            }
        }
        $validated = Validator::make($input, $rules)->validate();
        $contactValidator = Validator::make($request->all(), [
            'contacts' => 'nullable|array',
            'contacts.*.name' => 'required|string|max:255',
            'contacts.*.mobile' => 'required|string|max:20',
            'contacts.*.designation' => 'nullable|string|max:255',
        ]);

        if ($contactValidator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $contactValidator->errors()
            ], 422);
        }

        do {
            $metGroupId = 'MET' . rand(10000, 99999);
            $exists = Meeting::where('meeting_group', $metGroupId)->exists();
        } while ($exists);
        foreach ($fieldMap as $fieldId => $slug) {

            $field = Field::find($fieldId);
            if (!$field) continue;

            $value = $validated[$slug] ?? null;
            if ($field->type === 'file') {
                if ($request->hasFile($fieldId)) {
                    $file = $request->file($fieldId);
                    $filename = $formGroupId . "_" . $slug . "_" . time() . "." . $file->getClientOriginalExtension();
                    $path = 'form_data/';
                    $file->move(public_path($path), $filename);
                    $value = $path . $filename;
                }
            }
            Meeting::create([
                'form_group_id' => $formGroupId,
                'meeting_group' => $metGroupId,
                'emp_id'      => $request->emp_id ?? Auth::user()->id,             
                'field_id'      => $fieldId,
                'label'    => $field->name,
                'value'   => $value,
            ]);
        }
        $lastLogin = LoginHistory::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();
        $platform = $lastLogin->device ?? 'Unknown';
        if (!empty($request->emp_id)) {
            $user = User::findOrFail($request->emp_id);
            $employeeName = $user->name;
        } else {
            $employeeName = Auth::user()->name;
        }

        $extraFields = [
            'Employee Name'     => $employeeName,
            'Platform'          => $platform,
        ];

        foreach ($extraFields as $label => $value) {
            if (!empty($value)) {
                Meeting::create([
                    'form_group_id' => $formGroupId,
                    'meeting_group' => $metGroupId,
                    'emp_id'        => $request->emp_id ?? Auth::user()->id,
                    'label'         => $label,
                    'value'         => $value,
                ]);
            }
        }

        if ($request->has('contacts')) {

            foreach ($request->contacts as $index => $contact) {

                // Person Name
                Meeting::create([
                    'form_group_id' => $formGroupId,
                    'meeting_group' => $metGroupId,
                    'emp_id'        => $request->emp_id ?? Auth::user()->id,
                    'label'         => 'Person Name',
                    'value'         => $contact['name'],
                ]);

                // Mobile Number
                Meeting::create([
                    'form_group_id' => $formGroupId,
                    'meeting_group' => $metGroupId,
                    'emp_id'        => $request->emp_id ?? Auth::user()->id,
                    'label'         => 'Mobile Number',
                    'value'         => $contact['mobile'],
                ]);

                // Designation (optional)
                if (!empty($contact['designation'])) {
                    Meeting::create([
                        'form_group_id' => $formGroupId,
                        'meeting_group' => $metGroupId,
                        'emp_id'        => $request->emp_id ?? Auth::user()->id,
                        'label'         => 'Designation',
                        'value'         => $contact['designation'],
                    ]);
                }
            }
        }

        return response()->json([
            'status'  => true,
            'message' => 'Lead saved successfully!',
            'group_id' => $formGroupId
        ]);
    }
    public function meetings_delete($id)
    {
        Meeting::where('meeting_group', $id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Meeting deleted successfully'
        ]);
    }

    public function leads_excel_upload(Request $request)
    {
        set_time_limit(0);
        ini_set('max_execution_time', 0);

        $request->validate([
            'excel' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        // Convert Excel file to array
        $rows = Excel::toArray([], $request->file('excel'))[0];

        if (empty($rows)) {
            return response()->json([
                'status' => false,
                'message' => 'Excel file is empty',
                'created' => 0,
                'skipped' => 0
            ]);
        }

        // Remove header row
        $header = array_shift($rows);

        // Trim header values
        $header = array_map('trim', $header);

        // Get Lead Master fields
        $templates = TemplateMaster::with('field')
            ->where('name', 'Lead Master')
            ->orderBy('order_no')
            ->get();

        // Map Excel columns to DB fields
        $fieldMap = [];
        foreach ($templates as $t) {
            $fieldName = trim($t->field->name); // remove extra spaces
            $fieldMap[$fieldName] = [
                'field_id' => $t->field->id,
                'name'     => $fieldName,
            ];
        }

        $created = 0;
        $skipped = 0;

        foreach ($rows as $row) {

            // Combine header and row
            $rowData = array_combine($header, $row);

            // Trim column names
            $rowData = array_combine(
                array_map('trim', array_keys($rowData)),
                array_values($rowData)
            );

            /** -------------------------
             * SITE NAME CHECK
             * ------------------------- */
            $siteNameValue = trim($rowData['Site Name'] ?? '');
            if (!$siteNameValue) {
                $skipped++;
                continue;
            }
            // Check if this Site Name already exists
            $exists = TemplateData::where('template_name', 'Lead Master')
                ->where('field_name', 'Site Name')
                ->where('field_value', $siteNameValue)
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }
            $employeeName = trim($rowData['Employee Name'] ?? '');

            if (strcasecmp($employeeName, 'All User') === 0) {
                $empId = 0;
            } elseif (!empty($employeeName)) {
                $empId = User::where('name', $employeeName)->value('id') ?? Auth::id();
            } else {
                $empId = Auth::id();
            }

            /** -------------------------
             * CREATE FORM GROUP ID
             * ------------------------- */
            do {
                $formGroupId = 'RF' . rand(10000, 99999);
            } while (TemplateData::where('form_group_id', $formGroupId)->exists());            

            /** -------------------------
             * LOOP FIELDS
             * ------------------------- */
            foreach ($rowData as $columnName => $value) {
                $columnName = trim($columnName);
                
                if (!isset($fieldMap[$columnName])) {
                    continue; // skip if no matching field
                }

                $createdAt = now();
                $updatedAt = now();

                // Excel date conversion
                if (!empty($rowData['Created Date'])) {
                    $createdAt = is_numeric($rowData['Created Date'])
                        ? Date::excelToDateTimeObject($rowData['Created Date'])->format('Y-m-d H:i:s')
                        : date('Y-m-d H:i:s', strtotime($rowData['Created Date']));
                }

                if (!empty($rowData['Updated Date'])) {
                    $updatedAt = is_numeric($rowData['Updated Date'])
                        ? Date::excelToDateTimeObject($rowData['Updated Date'])->format('Y-m-d H:i:s')
                        : date('Y-m-d H:i:s', strtotime($rowData['Updated Date']));
                }
                
                TemplateData::create([
                    'form_group_id' => $formGroupId,
                    'template_name' => 'Lead Master',
                    'emp_id'        => $empId,
                    'field_id'      => $fieldMap[$columnName]['field_id'],
                    'field_name'    => $fieldMap[$columnName]['name'],
                    'field_value'   => $value,
                    'created_at'    => $createdAt ?? now(),
                    'updated_at'    => $updatedAt ?? now(),
                ]);
            }

            $created++;
        }

        return response()->json([
            'status'  => true,
            'message' => 'Excel import completed',
            'created' => $created,
            'skipped' => $skipped
        ]);
    }
    public function lead_Meeting_Excel_Upload(Request $request)
    {
        set_time_limit(0);
        ini_set('max_execution_time', 0);
        
        $request->validate([
            'excel' => 'required|file|mimes:xlsx,xls,csv'
        ]);
        $rows = Excel::toArray([], $request->file('excel'))[0];

        if (empty($rows)) {
            return response()->json([
                'status' => false,
                'message' => 'Excel file is empty',
                'created' => 0,
                'skipped' => 0
            ]);
        }

        $header = array_shift($rows);

        $header = array_map('trim', $header);

        $templates = TemplateMaster::with('field')->where('name', 'Lead Meetings')->orderBy('order_no')->get();
        
        $fieldMap = [];
        foreach ($templates as $t) {
            $fieldName = trim($t->field->name);
            $fieldMap[$fieldName] = [
                'field_id' => $t->field->id,
                'name'     => $fieldName,
            ];
        }
        $fieldMap['Employee Name'] = [
            'field_id' => null,
            'name'     => 'Employee Name',
        ];

        $fieldMap['Platform'] = [
            'field_id' => null,
            'name'     => 'Platform',
        ];
        $created = 0;
        $skipped = 0;
        foreach ($rows as $row) {

            // Combine header and row
            $rowData = array_combine($header, $row);

            // Trim column names
            $rowData = array_combine(
                array_map('trim', array_keys($rowData)),
                array_values($rowData)
            );

            /** -------------------------
             * SITE NAME CHECK
             * ------------------------- */
            $siteNameValue = trim($rowData['Site Name'] ?? '');
            if (!$siteNameValue) {
                $skipped++;
                continue;
            }
            $sitenamedata = TemplateData::where('template_name', 'Lead Master')->where('field_name', 'Site Name')->where('field_value', $siteNameValue)->first();
            if (!$sitenamedata) {
                $skipped++;
                continue;
            }
            $employeeName = trim($rowData['Employee Name'] ?? '');

            if (strcasecmp($employeeName, 'All User') === 0) {
                $empId = 0;
            } elseif (!empty($employeeName)) {
                $empId = User::where('name', $employeeName)->value('id') ?? Auth::id();
            } else {
                $empId = Auth::id();
            }

            $formGroupId = $sitenamedata->form_group_id;
            do {
                $metGroupId = 'MET' . rand(10000, 99999);
                $exists = Meeting::where('meeting_group', $metGroupId)->exists();
            } while ($exists);
            foreach ($rowData as $column => $value) {
                
                if (is_numeric($rowData['Created Date'])) {
                    $created_date = Date::excelToDateTimeObject($rowData['Created Date'])
                        ->format('Y-m-d');
                } else {
                    $created_date = $rowData['Created Date']; // already text date
                }
                if (is_numeric($rowData['Updated Date'])) {
                    $updated_date = Date::excelToDateTimeObject($rowData['Created Date'])
                        ->format('Y-m-d');
                } else {
                    $updated_date = $rowData['Updated Date']; // already text date
                }
                // Ignore system columns
                if (in_array($column, ['Site Name'])) {
                    continue;
                }

                if (!isset($fieldMap[$column])) {
                    continue; // unmatched header
                }
                Meeting::create([
                    'form_group_id' => $formGroupId,
                    'meeting_group' => $metGroupId,
                    'field_id'      => $fieldMap[$column]['field_id'],
                    'emp_id'        => $empId,
                    'label'         => $column,
                    'value'         => $value,
                    'created_at'    => $created_date ?? now(),
                    'updated_at'    => $updated_date ?? now(),
                ]);
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Lead meeting Excel uploaded successfully'
        ]);
    }
    public function lead_master_filter(Request $request)
    {
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

        $dateExpression = "
            CASE
                WHEN value LIKE '%/%/%' THEN STR_TO_DATE(value, '%m/%d/%Y')
                WHEN value LIKE '%-%-%' THEN STR_TO_DATE(value, '%Y-%m-%d')
                WHEN value LIKE '%/%/%' THEN STR_TO_DATE(value, '%d/%m/%Y')
                WHEN value LIKE '%-%-%' THEN STR_TO_DATE(value, '%d-%m-%Y')
                ELSE NULL
            END
        ";

        $query = TemplateData::query()
            ->with(['field', 'latestMeeting'])
            ->where('template_name', 'Lead Master')
            ->empScope();

        if ($request->filled('employee')) {
            $query->whereIn('emp_id', $request->employee);
        }       
        if ($request->filled('next_meeting_date')) {

            $latestMeetingsSub = Meeting::empScope()
                ->select(
                    'form_group_id',
                    DB::raw('MAX(created_at) as latest_created_at')
                )
                ->where('label', 'Next Meeting Date')
                ->groupBy('form_group_id');

            $leadIds = DB::table('meetings as m')
                ->joinSub($latestMeetingsSub, 'lm', function ($join) {
                    $join->on('m.form_group_id', '=', 'lm.form_group_id')
                        ->on('m.created_at', '=', 'lm.latest_created_at');
                })
                ->where('m.label', 'Next Meeting Date')
                ->whereNotNull('m.value')
                ->where('m.value', '!=', '0000-00-00')
                ->whereDate(DB::raw($dateExpression), $request->next_meeting_date)                
                ->pluck('m.form_group_id');

            $query->whereIn('form_group_id', $leadIds);
        }       
        // Dynamic filters based on map
        $map = [
            'label'         => 'Labels',            
            'area'          => 'Area',
            'lead_type'     => 'Lead Type',
            'site_stage'    => 'Site Stage',
            'project_type'  => 'Project Type',
            'customer_type' => 'Customer Type',
            'sp_product'    => 'SP Focused Product',
            'lead_source'   => 'Lead Source',
        ];

        foreach ($map as $fieldKey => $fieldLabel) {
            if ($request->filled($fieldKey)) {

                $values = (array) $request->$fieldKey;

                $matchedGroupIds = TemplateData::query()
                    ->where('template_name', 'Lead Master')
                    ->whereHas('field', function ($q) use ($fieldLabel, $values) {
                        $q->where('field_name', $fieldLabel)
                            ->whereIn('field_value', $values);
                    })
                    ->pluck('form_group_id');

                $query->whereIn('form_group_id', $matchedGroupIds);
            }
        }

        $groupId = $query->pluck('form_group_id')->unique()->values();

        // NUMERIC FILTERS
        $this->applyNumberFilter($query, $request, 'Number of Bathrooms', 'bathroom', 'bathroom_op');
        $this->applyNumberFilter($query, $request, 'Number of Floors', 'floor', 'floor_op');
        $this->applyNumberFilter($query, $request, 'Number of Towers', 'tower', 'tower_op');

        // GROUP BY form_group_id
        $leadRows = $query->get()->groupBy('form_group_id');

        $latestMeetingSub = Meeting::select(
            'form_group_id',
                DB::raw('MAX(id) as latest_id')
            )
            ->whereIn('form_group_id', $groupId)
            ->groupBy('form_group_id');

        $latestMeetingGroupSub = Meeting::joinSub($latestMeetingSub, 'lm', function ($join) {
                $join->on('meetings.id', '=', 'lm.latest_id');
            })
            ->select(
                'meetings.form_group_id',
                'meetings.meeting_group'
            );
            
        $latestMeetings = Meeting::joinSub($latestMeetingGroupSub, 'lg', function ($join) {
            $join->on('meetings.form_group_id', '=', 'lg.form_group_id')
                ->on('meetings.meeting_group', '=', 'lg.meeting_group');
            })
            ->orderBy('meetings.created_at')
            ->get()
            ->groupBy('form_group_id');

        $meetingCounts = Meeting::query()
            ->empScope()
            ->whereIn('form_group_id', $groupId)
            ->select('form_group_id')
            ->selectRaw('COUNT(DISTINCT meeting_group) as total_meetings')
            ->groupBy('form_group_id')
            ->pluck('total_meetings', 'form_group_id');

        $finalData = $leadRows->map(function ($leadRows, $groupId) use ($latestMeetings, $meetingCounts) {
            return [
                'form_group_id' => $groupId,
                'lead'          => $leadRows,
                'meeting'       => $latestMeetings[$groupId] ?? null,
                'meeting_count' => $meetingCounts[$groupId] ?? 0,
            ];
        });
        if ($finalData->isEmpty()) {
            return response()->json([
                'success' => false,
                'html' => null
            ]);
        }
        return response()->json([
            'success' => true,
            'html' => view('admin.partials.lead_master_filter', compact('finalData', 'fieldsorder', 'tablefield'))->render()
        ]);
    }

    private function applyNumberFilter($query, $request, $fieldName, $valueKey, $opKey)
    {
        $allowedOps = ['=', '<', '>'];

        if ($request->filled($valueKey) && $request->filled($opKey)) {

            // Validate operator
            $op = in_array($request->$opKey, $allowedOps) ? $request->$opKey : '=';

            // Get form_group_ids that match numeric condition
            $matchedGroupIds = TemplateData::query()
                ->where('template_name', 'Lead Master')
                ->whereHas('field', function ($q) use ($fieldName, $request, $valueKey, $op) {
                    $q->where('field_name', $fieldName)
                        ->whereRaw("CAST(field_value AS UNSIGNED) {$op} ?", [$request->$valueKey]);
                })
                ->pluck('form_group_id');

            // Apply to main query
            if ($matchedGroupIds->isNotEmpty()) {
                $query->whereIn('form_group_id', $matchedGroupIds);
            } else {
                // If no matches, force empty result
                $query->whereRaw('0 = 1');
            }
        }
    }
}
