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

        $createdTemplates = [];

        foreach ($request->field_ids as $fieldId) {
            $template = TemplateMaster::create([
                'name' => $request->name,
                'field_id' => $fieldId
            ]);

            $createdTemplates[] = $template;
        }

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
            'field_ids' => 'required|array|min:1',
            'field_ids.*' => 'exists:fields,id',
            'name' => 'required|string',
            'new_name' => 'required|string',
        ]);

        // Get all existing template field IDs
        $existingFieldIds = TemplateMaster::where('name', $request->name)
            ->pluck('field_id')
            ->toArray();

        if (empty($existingFieldIds)) {
            return response()->json([
                'status' => false,
                'message' => 'Template not found.',
            ], 404);
        }

        $now = now();

        // 1️⃣ Update existing fields and create new ones
        foreach ($request->field_ids as $fieldId) {
            TemplateMaster::updateOrCreate(
                ['name' => $request->name, 'field_id' => $fieldId],
                ['name' => $request->new_name, 'updated_at' => $now]
            );
        }

        // 2️⃣ Delete fields that are no longer in the request
        $toDelete = array_diff($existingFieldIds, $request->field_ids);

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
    public function template_data_list()
    {
        $templateData = TemplateData::orderBy('created_at', 'desc')
            ->get()
            ->groupBy('template_name')
            ->map(function ($templateGroup) {
                $templateFields = $templateGroup
                    ->pluck('field_name', 'field_id')
                    ->unique();
                $formGroups = $templateGroup->groupBy('form_group_id');

                return [
                    'fields' => $templateFields,
                    'groups' => $formGroups
                ];
            });
        return view('admin.template_data.list', compact('templateData'));
    }

    public function create_template_data()
    {
        $templateNames = TemplateMaster::select('name')
            ->groupBy('name')
            ->orderBy('name', 'asc')
            ->get();

        $fields = Field::orderBy('id', 'desc')->get()->groupBy('name');

        return view('admin.template_data.create', compact('templateNames', 'fields'));
    }
    public function get_template_data_fields(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);
        $templates = TemplateMaster::with(['field', 'field.dropdowns'])->where('name', $request->name)->orderBy('id', 'desc')->get();
        if ($templates->isEmpty()) {
            return response()->json([
                'status' => false,
                'fields' => []
            ]);
        }
        return response()->json([
            'status' => true,
            'fields' => $templates
        ]);
    }
    public function template_data_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
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
                'template_name' => $request->name,
                'field_id'      => $fieldId,
                'field_name'    => $fieldName,
                'field_value'   => $value,
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Template data saved successfully!',
        ]);
    }
    public function template_data_edit($groupId)
    {
        $records = TemplateData::with(['field', 'field.dropdowns'])->where('form_group_id', $groupId)->get();
        if ($records->isEmpty()) {
            return abort(404, "Form group not found");
        }
        $templateName = $records->first()->template_name;
        $templateFields = $records->pluck('field_name', 'field_id');
        return view('admin.template_data.edit', compact(
            'groupId',
            'records',
            'templateName',
            'templateFields'
        ));
    }
    public function template_data_update(Request $request)
    {
        $request->validate([
            'template_name' => 'required|string'
        ]);

        $records = TemplateData::with('field')
            ->where('form_group_id', $request->group_id)
            ->get();

        if ($records->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => "Form group not found."
            ]);
        }
        $formGroupId = $request->group_id;
        foreach ($records as $record) {
            $fieldid = $record->field_id;          
            $fieldType = $record->field->type;
            $newValue  = $request->input($fieldid);

            if ($fieldType === 'file') {
                if ($request->hasFile($fieldid)) {
                    $file = $request->file($fieldid);
                    if (is_array($file)) {
                        $file = $file[0];
                    }
                    $filename = $formGroupId . "_" . $fieldid . "_" . time() . "." . $file->getClientOriginalExtension();
                    $path = 'from_data/';
                    $file->move(public_path($path), $filename);
                    $newValue = $path . $filename;
                }
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

    public function template_data_delete($groupId)
    {
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
}
