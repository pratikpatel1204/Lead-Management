<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\TemplateData;
use Illuminate\Http\Request;
use App\Models\TemplateMaster;
use Illuminate\Pagination\LengthAwarePaginator;

class TemplateMasterController extends Controller
{

    public function template_list(Request $request)
    {
        $allTemplates = TemplateMaster::with('field')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('name');

        $perPage = 6;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedData = $allTemplates->forPage($currentPage, $perPage);

        $templates = new LengthAwarePaginator(
            $pagedData,
            $allTemplates->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.template.list', compact('templates'));
    }


    public function create_template()
    {
        $fields = Field::orderBy('id', 'desc')->get();
        return view('admin.template.create', compact('fields'));
    }

    public function template_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'field_ids' => 'required|array|min:1',
            'field_ids.*' => 'exists:fields,id',
        ]);

        $orderList = explode(',', $request->field_order);
        $createdTemplates = [];
        foreach ($orderList as $position => $fieldId) {
            $template = TemplateMaster::create([
                'name'      => $request->name,
                'field_id'  => $fieldId,
                'order_no'  => $position + 1
            ]);
            $createdTemplates[] = $template;
        }
        $createdTemplates = [];
        return response()->json([
            'status' => true,
            'message' => 'Templates created successfully for all selected fields!',
            'count' => count($createdTemplates),
            'data' => $createdTemplates,
        ]);
    }


    public function template_edit($name)
    {
        $templates = TemplateMaster::where('name', $name)->get();
        if ($templates->isEmpty()) {
            return redirect()->route('admin.template.list')->with('error', 'Template not found.');
        }
        $fields = Field::all();
        return view('admin.template.edit', compact('templates', 'fields', 'name'));
    }
    public function template_update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',          // old name
            'new_name' => 'required|string',      // updated name
            'field_ids' => 'required|array|min:1',
            'field_ids.*' => 'exists:fields,id',
            'field_order' => 'required|string'    // "3,5,9,2"
        ]);

        // Convert field order string to array
        $orderedFieldIds = array_filter(explode(',', $request->field_order));

        // Safety check: must match selected field_ids
        $fieldIds = $request->field_ids;

        // Get existing template entries by old name
        $existing = TemplateMaster::where('name', $request->name)->get();

        if ($existing->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Template not found.',
            ], 404);
        }

        $existingIds = $existing->pluck('field_id')->toArray();

        // -------------------------------
        // 1️⃣ Add / Update fields
        // -------------------------------

        $order = 1;
        foreach ($orderedFieldIds as $fieldId) {

            TemplateMaster::updateOrCreate(
                [
                    'name' => $request->name,
                    'field_id' => $fieldId
                ],
                [
                    'name' => $request->new_name,
                    'order_no' => $order++,      // Save correct order
                    'updated_at' => now()
                ]
            );
        }

        // -------------------------------
        // 2️⃣ Delete removed fields
        // -------------------------------
        $toDelete = array_diff($existingIds, $fieldIds);

        if (!empty($toDelete)) {
            TemplateMaster::where('name', $request->name)
                ->whereIn('field_id', $toDelete)
                ->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Template updated successfully!',
        ]);
    }


    public function template_delete($name)
    {
        $templates = TemplateMaster::where('name', $name)->get();

        if ($templates->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Template not found.',
            ], 404);
        }

        TemplateMaster::where('name', $name)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Template deleted successfully!',
        ]);
    }

    public function data_list($name)
    {
        $templates = TemplateData::with('field')
            ->where('template_name', $name)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('form_group_id');

        return view('admin.form_data.list', compact('templates', 'name'));
    }
    public function create_data($name)
    {
        $templates = TemplateMaster::with(['field', 'field.dropdowns'])->where('name', $name)->orderBy('order_no', 'asc')->get();
        return view('admin.form_data.create', compact('templates', 'name'));
    }
    public function data_store(Request $request)
    {
        $request->validate([
            'template_name' => 'required|string',
            'label_id' => 'required|array|min:1',
            'label_id.*' => 'exists:fields,id'
        ]);
        do {
            $formGroupId = 'RF' . rand(10000, 99999);
            $exists = TemplateData::where('form_group_id', $formGroupId)->exists();
        } while ($exists);

        foreach ($request->label_id as $fieldId) {

            $field = Field::find($fieldId);
            if (!$field) continue;
            $fieldName = $field->name;
            $value = $request->input($fieldId);
            if ($field->type == 'file') {
                if ($request->hasFile($fieldId)) {
                    $file = $request->file($fieldId);
                    $filename = $formGroupId . "_" . $fieldId . "_" . time() . "." . $file->getClientOriginalExtension();
                    $path = 'from_data/';
                    $file->move(public_path($path), $filename);
                    $value = $path . $filename;
                }
            }
            TemplateData::create([
                'form_group_id' => $formGroupId,
                'template_name' => $request->template_name,
                'field_id'      => $fieldId,
                'field_name'    => $fieldName,
                'field_value'   => $value,
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => $request->template_name . ' data saved successfully!',
        ]);
    }
    public function data_delete(Request $request)
    {
        $groupId = $request->group_id;
        $query = TemplateData::where('form_group_id', $groupId);
        if (!$query->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Form group not found.'
            ]);
        }
        $query->delete();
        return response()->json([
            'status' => true,
            'message' => 'Form group deleted successfully!'
        ]);
    }
    public function edit_data($name, $groupId)
    {
        $records = TemplateData::with(['field', 'field.dropdowns'])->where('form_group_id', $groupId)->get();
        if ($records->isEmpty()) {
            return abort(404, "Form group not found");
        }
        $templateName = $records->first()->template_name;
        $templateFields = $records->pluck('field_name', 'field_id');
        return view('admin.form_data.edit', compact(
            'groupId',
            'records',
            'templateName',
            'templateFields'
        ));
    }
    public function data_update(Request $request)
    {
        $request->validate([
            'template_name' => 'required|string',
            'group_id' => 'required',
        ]);

        $formGroupId = $request->input('group_id');

        $records = TemplateData::with('field')
            ->where('form_group_id', $formGroupId)
            ->get();

        if ($records->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => "Form group not found."
            ]);
        }
        foreach ($records as $record) {
            $fieldId = $record->field_id;
            $fieldType = $record->field->type ?? 'text';
            $newValue = $request->input($fieldId);
            if ($fieldType === 'checkbox') {
                $newValue = $request->has($fieldId) ? '1' : '0';
            } else if ($fieldType === 'file') {
                if ($request->hasFile($record->field_id) && $request->file($record->field_id) !== null) {
                    $file = $request->file($record->field_id);
                    if (is_array($file)) {
                        $file = $file[0];
                    }
                    $filename = $formGroupId . "_" . $record->field_id . "_" . time() . "." . $file->getClientOriginalExtension();
                    $path = 'from_data/';
                    $file->move(public_path($path), $filename);
                    $newValue = $path . $filename;
                } else {
                    $newValue = $record->field_value;
                }
            } else {
                $newValue = $newValue !== null ? $newValue : $record->field_value;
            }
            $record->update([
                'field_value' => $newValue,
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Template data updated successfully (Updated + Removed)!'
        ]);
    }
}
