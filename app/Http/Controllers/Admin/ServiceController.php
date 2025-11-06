<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function services_categories_list()
    {
        $categories = ServiceCategory::orderBy('id', 'DESC')->get();
        return view('admin.service.list_categories', compact('categories'));
    }
    public function create_services_categories()
    {
        return view('admin.service.create_categories');
    }
    public function services_categories_store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:service_categories,title',
            'short_description' => 'required|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:Active,Inactive',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'categories/';
            $file->move(public_path($path), $filename);
            $imagePath = $path . $filename;
        }

        ServiceCategory::create([
            'title' => $request->title,
            'short_description' => $request->short_description,
            'image' => $imagePath,
            'status' => $request->status,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Services Category created successfully',
        ]);
    }
    public function services_categories_edit($id)
    {
        $category = ServiceCategory::findOrFail($id);
        return view('admin.service.edit_categories', compact('category'));
    }
    public function services_categories_update(Request $request)
    {
        $category = ServiceCategory::findOrFail($request->id);
        $request->validate([
            'title' => 'required|string|max:255|unique:service_categories,title,' . $category->id,
            'short_description' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:Active,Inactive',
        ]);
        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'categories/';
            $file->move(public_path($path), $filename);
            $category->image = $path . $filename;
        }

        $category->title = $request->title;
        $category->short_description = $request->short_description;
        $category->status = $request->status;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Services Category Updated Successfully',
        ]);
    }
    public function services_categories_destroy($id)
    {
        $category = ServiceCategory::findOrFail($id);

        Service::where('category_id', $id)->delete();

        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category and related services deleted successfully'
        ]);
    }
    public function services_list()
    {
        $services = Service::with('category')->latest()->get();
        return view('admin.service.list_service', compact('services'));
    }
    public function create_services() {
        $categories = ServiceCategory::all();
        return view('admin.service.create_service', compact('categories'));
    }
    public function services_store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            $service = new Service();
            $service->category_id = $request->category_id;
            $service->title       = $request->title;
            $service->description = $request->description;
            if ($request->hasFile('image')) {               
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'services/';
                $file->move(public_path($path), $filename);
                $service->image = $path . $filename;
            }
            $service->save();

            return response()->json([
                'status'  => true,
                'message' => 'Service created successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
    public function services_edit($id)
    {
        $service = Service::findOrFail($id);
        $categories = ServiceCategory::all();

        return view('admin.service.edit_service', compact('service', 'categories'));
    }
    public function services_update(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            $service = Service::findOrFail($request->id);

            $service->category_id = $request->category_id;
            $service->title       = $request->title;
            $service->description = $request->description;

            if ($request->hasFile('image')) {

                // Delete old image if exists
                if ($service->image && file_exists(public_path($service->image))) {
                    unlink(public_path($service->image));
                }

                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'services/';
                $file->move(public_path($path), $filename);
                $service->image = $path . $filename;
            }

            $service->save();

            return response()->json([
                'status'  => true,
                'message' => 'Service updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function services_destroy($id)
    {
        $service = Service::findOrFail($id);

        if ($service->image && file_exists(public_path($service->image))) {
            unlink(public_path($service->image));
        }

        $service->delete();

        return response()->json(['success' => true]);
    }
}
