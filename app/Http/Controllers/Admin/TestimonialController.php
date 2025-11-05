<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function testimonials_list()
    {
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonial.list', compact('testimonials'));
    }
    public function create_testimonial()
    {
        return view('admin.testimonial.create');
    }

    // Store Testimonial
    public function store_testimonial(Request $request)
    {
        $request->validate([
            'star' => 'required|integer|min:1|max:5',
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'message' => 'required|string',
        ]);

        $testimonial = new Testimonial();
        $testimonial->star = $request->star;
        $testimonial->name = $request->name;
        $testimonial->designation = $request->designation;
        $testimonial->message = $request->message;

        // Image Upload      
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = 'testimonial/';
            $file->move(public_path($path), $filename);
            $testimonial->image = $path . $filename;
        }
        $testimonial->save();

        return response()->json([
            'success' => true,
            'message' => 'Testimonial created successfully',
        ]);
    }

    // Edit Page
    public function edit_testimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonial.edit', compact('testimonial'));
    }

    // Update Testimonial
    public function update_testimonial(Request $request)
    {
        $request->validate([
            'star' => 'required|integer|min:1|max:5',
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'message' => 'required|string',
        ]);

        $testimonial = Testimonial::findOrFail($request->id);
        $testimonial->star = $request->star;
        $testimonial->name = $request->name;
        $testimonial->designation = $request->designation;
        $testimonial->message = $request->message;

        if ($request->hasFile('image')) {
            // delete old file
            if ($testimonial->image && file_exists(public_path($testimonial->image))) {
                unlink(public_path($testimonial->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = 'testimonial/';
            $file->move(public_path($path), $filename);
            $testimonial->image = $path . $filename;            
        }

        $testimonial->save();

        return response()->json([
            'success' => true,
            'message' => 'Testimonial updated successfully',
        ]);
    }

    // Delete Testimonial
    public function destroy_testimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->image && file_exists(public_path($testimonial->image))) {
            unlink(public_path($testimonial->image));
        }

        $testimonial->delete();

        return response()->json([
            'status' => true,
            'message' => 'Testimonial deleted successfully',
        ]);
    }
}
