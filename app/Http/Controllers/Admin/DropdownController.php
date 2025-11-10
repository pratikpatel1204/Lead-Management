<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dropdown;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DropdownController extends Controller
{
    public function dropdown_list()
    {
        $fields = Field::where('type', 'select')->get();
        $dropdowns = Dropdown::all()->groupBy('field_id');
        return view('admin.field.dropdown_list', compact('fields', 'dropdowns'));
    }
    public function create_dropdown()
    {
        $fields = Field::where('type', 'select')->get();
        return view('admin.field.create_dropdown', compact('fields'));
    }
    public function dropdown_store(Request $request)
    {
        $options = [];
        if ($request->has('label') && $request->has('value')) {
            foreach ($request->label as $i => $label) {
                $val = $request->value[$i] ?? null;
                if (!empty($label) && !empty($val)) {
                    $options[] = [
                        'label' => $label,
                        'value' => $val,
                    ];
                }
            }

            $options = collect($options)->unique(function ($item) {
                return $item['label'] . '|' . $item['value'];
            })->values()->all();
        }

        $request->merge(['options' => $options]);

        $validator = Validator::make($request->all(), [
            'field_id' => 'required|exists:fields,id',
            'options'  => 'required|array|min:1',
            'options.*.label' => 'required|string|max:100',
            'options.*.value' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        Dropdown::where('field_id', $request->field_id)->delete();

        foreach ($request->options as $option) {
            Dropdown::create([
                'field_id' => $request->field_id,
                'label'    => $option['label'],
                'value'    => $option['value'],
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Dropdown options saved successfully!',
        ]);
    }
    public function dropdown_edit($fieldId)
    {
        $field = Field::where('id', $fieldId)
            ->where('type', 'select')
            ->firstOrFail();
        $dropdowns = Dropdown::where('field_id', $fieldId)->get();
        return view('admin.field.edit_dropdown', compact('field', 'dropdowns'));
    }
    public function dropdown_update(Request $request)
    {
        $field_id = $request->field_id;
        
        // Validate field_id and input arrays
        $validator = Validator::make($request->all(), [
            'field_id' => 'required|exists:fields,id',
            'label'    => 'required|array',
            'value'    => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed!',
                'errors' => $validator->errors()
            ], 422);
        }

        // Prepare options array, remove duplicates
        $options = [];
        $existingValues = [];
        foreach ($request->label as $i => $label) {
            $value = $request->value[$i] ?? null;
            if (!empty($label) && !empty($value) && !in_array($value, $existingValues)) {
                $options[] = [
                    'field_id' => $field_id,
                    'label'    => $label,
                    'value'    => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $existingValues[] = $value; // prevent duplicates
            }
        }

        if (empty($options)) {
            return response()->json([
                'status' => false,
                'message' => 'At least one valid option is required.'
            ], 422);
        }
        Dropdown::where('field_id', $field_id)->delete();
        Dropdown::insert($options);

        return response()->json([
            'status' => true,
            'message' => 'Dropdown updated successfully!',
            'data' => $options
        ], 200);
    }

    public function dropdown_delete($fieldId)
    {
        try {
            $deleted = Dropdown::where('field_id', $fieldId)->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Dropdown options deleted successfully.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No dropdown options found to delete.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting dropdown: ' . $e->getMessage()
            ]);
        }
    }
}
