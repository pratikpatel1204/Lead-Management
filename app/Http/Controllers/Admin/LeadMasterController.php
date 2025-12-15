<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\TemplateData;
use App\Models\TemplateMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LeadMasterController extends Controller
{
    public function lead_mater()
    {
        $templates = TemplateMaster::with(['field', 'field.templateData'])->where('name', 'Lead Mater')->orderBy('order_no', 'asc')->get();
        $leadData = TemplateData::where('template_name', 'Lead Mater')->get()->groupBy('form_group_id');
        return view('admin.lead.list', compact('templates', 'leadData'));
    }
    public function lead_mater_store(Request $request)
    {
        $templates = TemplateMaster::with('field')
            ->where('name', 'Lead Mater')
            ->orderBy('order_no')
            ->get();

        $rules = [];
        $input = $request->all();
        $fieldMap = [];

        foreach ($templates as $t) {
            $field = $t->field;
            $fieldId = $field->id;
            $slug  = Str::slug($field->name, '_');
            $fieldMap[$fieldId] = $slug;
            $rules[$slug] = $field->validation_type ?? 'nullable';
            if ($request->has($field->id)) {
                $input[$slug] = $request->input($field->id);
            }
        }

        $validated = Validator::make($input, $rules)->validate();

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
                'template_name' => 'Lead Mater',
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
    public function lead_mater_edit($formGroupId)
    {
        $leadData = TemplateData::with('field')->where('form_group_id', $formGroupId)->get();
        $templateName = $leadData->first()->template_name ?? 'Template';
        return view('admin.lead.edit', compact('leadData', 'templateName', 'formGroupId'));
    }
    public function lead_mater_update(Request $request)
    {
        $formGroupId = $request->form_group_id;

        // Get template fields
        $templates = TemplateMaster::with('field')
            ->where('name', 'Lead Mater')
            ->orderBy('order_no')
            ->get();

        $rules = [];
        $input = [];
        $fieldMap = [];

        // -----------------------------
        // Build validation rules
        // -----------------------------
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

        // ✅ VALIDATE
        $validated = Validator::make($input, $rules)->validate();

        foreach ($fieldMap as $fieldId => $slug) {

            $field = Field::find($fieldId);
            if (!$field) continue;

            // 🔥 FIND EXISTING RECORD
            $data = TemplateData::where('form_group_id', $formGroupId)
                ->where('field_id', $fieldId)
                ->first();

            if (!$data) continue;

            $value = $validated[$slug] ?? $data->field_value;

            // -----------------------------
            // FILE HANDLING
            // -----------------------------
            if ($field->type === 'file') {

                if ($request->hasFile($fieldId)) {
                    $file = $request->file($fieldId);
                    $filename = $formGroupId . "_" . $slug . "_" . time() . "." . $file->getClientOriginalExtension();
                    $path = 'form_data/';
                    $file->move(public_path($path), $filename);

                    // Delete old file
                    if ($data->field_value && file_exists(public_path($data->field_value))) {
                        unlink(public_path($data->field_value));
                    }

                    $value = $path . $filename;
                } else {
                    $value = $data->field_value; // keep old
                }
            }

            // ✅ UPDATE RECORD
            $data->update([
                'field_value' => $value
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Lead updated successfully!'
        ]);
    }
    public function lead_mater_delete(Request $request)
    {
        $request->validate([
            'group_id' => 'required|string'
        ]);

        $groupId = $request->group_id;

        // Get all records of this form group
        $records = TemplateData::where('form_group_id', $groupId)->get();

        if ($records->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found.'
            ]);
        }

        // -----------------------------
        // DELETE FILES (if any)
        // -----------------------------
        foreach ($records as $row) {
            if ($row->field_value && file_exists(public_path($row->field_value))) {
                @unlink(public_path($row->field_value));
            }
        }

        // -----------------------------
        // DELETE DATABASE RECORDS
        // -----------------------------
        TemplateData::where('form_group_id', $groupId)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Form group deleted successfully!'
        ]);
    }
}
