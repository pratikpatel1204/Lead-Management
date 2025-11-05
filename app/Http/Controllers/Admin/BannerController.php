<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function banner_list(){
        $banners = Banner::latest()->get();
        return view('admin.banner.list', compact('banners'));
    }
    public function create_banner(){
        return view('admin.banner.create');
    }
    public function store_banner(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:Active,Inactive',
        ]);

        try {
            $banner = new Banner();
            $banner->title = $request->title;
            $banner->status = $request->status ?? 'Active';

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = 'banners/'; 
                $file->move(public_path($path), $filename);
                $banner->image = $path . $filename;
            }

            $banner->save();

            return response()->json([
                'status' => true,
                'message' => 'Banner created successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function edit_banner($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('banner'));
    }
    public function update_banner(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:Active,Inactive',
        ]);

        $banner = Banner::findOrFail($request->id);
        $banner->title = $request->title;
        $banner->status = $request->status;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' .$file->getClientOriginalExtension();
            $path = 'banners/';
            $file->move(public_path($path), $filename);
            if ($banner->image && file_exists(public_path($banner->image))) {
                unlink(public_path($banner->image));
            }
            $banner->image = $path . $filename;
        }

        $banner->save();

        return response()->json(['status' => true, 'message' => 'Banner updated successfully']);
    }

    public function destroy_banner($id)
    {
        $banner = Banner::findOrFail($id);
        if ($banner->image && file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }       
        $banner->delete();

        return response()->json(['status' => true, 'message' => 'Banner deleted successfully']);
    }
}
