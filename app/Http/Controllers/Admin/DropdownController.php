<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dropdown;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DropdownController extends Controller
{
    public function dropdown_list($id)
    {
        $field = Field::where('id', $id)->first();
        $dropdowns = Dropdown::where('field_id', $id)->get();
        return view('admin.dropdown.list', compact('dropdowns', 'field'));
    }  
    public function create_dropdown($id)
    {
        $field = Field::where('id', $id)->first();
        return view('admin.dropdown.create', compact('field'));
    }
    public function dropdown_store(Request $request)
    {
        $request->validate([
            'id'     => 'required|integer',
            'label'  => 'required|string',
            'value'  => 'required|string',
        ]);
        Dropdown::create([
            'field_id'  => $request->id,
            'label'     => $request->label,
            'value'     => $request->value,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Dropdown options saved successfully!',
        ]);
    }   
    public function dropdown_edit($id)
    {
        $dropdown = Dropdown::with('field')->findOrFail($id);
        return view('admin.dropdown.edit', compact('dropdown'));
    }
    public function dropdown_update(Request $request)
    {
        $request->validate([
            'id'     => 'required|integer',
            'label'  => 'required|string',
            'value'  => 'required|string',
        ]);

        $dropdown = Dropdown::findOrFail($request->id);
        $dropdown->label = $request->label;
        $dropdown->value = $request->value;
        $dropdown->save();
        return response()->json([
            'status' => true,
            'message' => 'Dropdown updated successfully!',
        ]);
    }
    public function dropdown_delete(Request $request)
    {
        $dropdown = Dropdown::findOrFail($request->id);
        $dropdown->delete();

        return response()->json([
            'status' => true,
            'message' => 'Dropdown options deleted successfully.'
        ]);
    }    
}
