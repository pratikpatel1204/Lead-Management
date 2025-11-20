<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\FieldType;
use App\Models\ValidationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;

class FieldController extends Controller
{
    public function field_list()
    {
        $fields = Field::orderBy('id', 'desc')->get();
        return view('admin.field.list_field', compact('fields'));
    }
    public function create_field()
    {
        $fieldTypes = FieldType::latest()->get();
        $validationTypes = ValidationType::orderBy('id', 'desc')->get();

        return view('admin.field.create_field', compact('fieldTypes', 'validationTypes'));
    }
    public function field_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'             => 'required|string|max:100',
            'type'             => 'required|string',
            'validation'       => 'required|string',
            'validation_type'  => 'nullable|string',
            'default_value'    => 'nullable|string|max:255',
            'options'          => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $field = new Field();
        $field->name = $request->name;
        $field->type = $request->type;
        $field->validation = $request->validation;
        $field->validation_type = $request->validation_type;
        $field->default_value = $request->default_value;
        $field->options = $request->options;
        $field->save();

        return response()->json([
            'status' => true,
            'message' => 'Field created successfully!',
            'data' => $field
        ], 200);
    }
    public function field_edit($id)
    {
        try {
            $field = Field::find($id);

            if (!$field) {
                return redirect()->route('admin.field.list')
                    ->with('error', 'Field not found.');
            }

            $fieldTypes = FieldType::orderBy('id', 'desc')->get();
            $validationTypes = ValidationType::orderBy('id', 'desc')->get();

            return view('admin.field.edit_field', compact('field', 'fieldTypes', 'validationTypes'));
        } catch (\Exception $e) {
            return redirect()->route('admin.field.list')
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function field_update(Request $request)
    {
        // ✅ Validate input data
        $validator = Validator::make($request->all(), [
            'id'               => 'required|exists:fields,id',
            'name'             => 'required|string|max:100',
            'type'             => 'required|string',
            'validation'       => 'required|string',
            'validation_type'  => 'nullable|string',
            'default_value'    => 'nullable|string|max:255',
            'options'          => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $field = Field::findOrFail($request->id);
            $field->name = $request->name;
            $field->type = $request->type;
            $field->validation = $request->validation;
            $field->validation_type = $request->validation_type;
            $field->default_value = $request->default_value;
            $field->options = $request->options;
            $field->save();

            return response()->json([
                'status' => true,
                'message' => 'Field updated successfully!',
                'data' => $field
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while updating the field.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function field_delete($id)
    {
        try {
            $field = Field::find($id);

            if (!$field) {
                return response()->json([
                    'status' => false,
                    'message' => 'Field not found.'
                ], 404);
            }

            $field->delete();

            return response()->json([
                'status' => true,
                'message' => 'Field deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }



    public function field_type_list()
    {
        $fieldTypes = FieldType::latest()->get();
        return view('admin.field.field_type_list', compact('fieldTypes'));
    }
    public function create_field_type()
    {
        return view('admin.field.create_field_type');
    }
    public function field_type_store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255|unique:field_types,name',
            'value' => 'required|string|max:255',
        ], [
            'name.required'  => 'Field Name is required.',
            'name.unique'    => 'This field name already exists.',
            'value.required' => 'Field Value is required.',
        ]);

        $fieldType = FieldType::create([
            'name'  => $validated['name'],
            'value' => $validated['value'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Field Type created successfully!',
            'data'    => $fieldType
        ]);
    }
    public function field_type_edit($id)
    {
        $fieldType = FieldType::findOrFail($id);
        return view('admin.field.edit_type', compact('fieldType'));
    }
    public function field_type_update(Request $request)
    {
        $fieldType = FieldType::find($request->id);

        if (!$fieldType) {
            return response()->json([
                'success' => false,
                'message' => 'Field type not found.'
            ], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:field_types,name,' . $request->id,
            'value' => 'required|string|max:255',
        ]);

        $fieldType->name = $request->name;
        $fieldType->value = $request->value;
        $fieldType->save();

        return response()->json([
            'success' => true,
            'message' => 'Field Type updated successfully.',
            'data' => $fieldType
        ]);
    }

    public function field_type_delete($id)
    {
        try {
            $fieldType = FieldType::find($id);

            if (!$fieldType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Field Type not found.',
                ], 404);
            }

            $fieldType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Field Type deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }
    public function downloadSample()
    {
        $fileName = 'field_sample.xlsx';

        $writer = SimpleExcelWriter::streamDownload($fileName);

        $writer->addHeader(['#', 'Field Name', 'Type', 'Validation', 'Validation Type', 'options', 'Default Value'])
            ->addRows([
                ['1', 'Name', 'text', 'required', 'string','-', 'John Doe'],
                ['2', 'Email', 'email', 'required', 'email','-', 'johndoe@email.com'],
                ['3', 'Age', 'number', 'nullable', 'integer','-', '25'],
                ['4', 'Is Active', 'checkbox', 'checked', 'boolean','-', 'true'],
                ['5', 'Gender', 'radio', 'required', 'string', 'Male, Female', 'Male'],
            ])
            ->toBrowser();
    }
    public function fields_bulk_upload(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,csv,xls',
        ]);

        try {
            $file = $request->file('excel_file');
            $filePath = $file->storeAs('temp', $file->getClientOriginalName());

            $fullPath = storage_path('app/' . $filePath);

            $rows = \Spatie\SimpleExcel\SimpleExcelReader::create($fullPath)->getRows();

            DB::beginTransaction();

            $rows->each(function (array $row) {
                Field::create([
                    'name' => $row['Field Name'] ?? null,
                    'type' => $row['Type'] ?? null,
                    'validation' => $row['Validation'] ?? null,
                    'validation_type' => $row['Validation Type'] ?? null,
                    'options' => $row['options'] ?? null,
                    'default_value' => $row['Default Value'] ?? null,
                ]);
            });

            DB::commit();

            Storage::delete($filePath);

            return response()->json([
                'status' => true,
                'message' => 'Fields imported successfully!',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error importing Excel: ' . $th->getMessage(),
            ], 500);
        }
    }
}
