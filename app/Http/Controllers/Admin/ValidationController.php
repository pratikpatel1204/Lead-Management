<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ValidationType;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function validation_list()
    {
        $validationTypes = ValidationType::orderBy('id', 'desc')->get();
        return view('admin.field.validation_list', compact('validationTypes'));
    }

    public function create_validation()
    {
        return view('admin.field.create_validation');
    }
    public function validation_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:validations_type,name',
            'rule' => 'required|string|max:255|unique:validations_type,rule',
        ]);

        $validation = new ValidationType();
        $validation->name = $request->name;
        $validation->rule = $request->rule;
        $validation->save();

        return response()->json(['success' => true]);
    }
    public function validation_edit($id)
    {
        $validationType = ValidationType::find($id);
        if (!$validationType) {
            return redirect()->route('admin.validation.type.list')
                ->with('error', 'Validation type not found.');
        }
        return view('admin.field.validation_edit', compact('validationType'));
    }
    public function validation_update(Request $request)
    {
        $validationType = ValidationType::find($request->id);

        if (!$validationType) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Type not found.'
            ], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:validations_type,name,' . $request->id,
            'rule' => 'required|string|max:255|unique:validations_type,rule,' . $request->id,
        ]);

        $validationType->name = $request->name;
        $validationType->rule = $request->rule;
        $validationType->save();

        return response()->json([
            'success' => true,
            'message' => 'Validation Type updated successfully.'
        ]);
    }

    public function validation_delete($id)
    {
        try {
            $validationType = ValidationType::find($id);
            if (!$validationType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation type not found.'
                ]);
            }
            $validationType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Validation type deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! ' . $e->getMessage()
            ]);
        }
    }
}
