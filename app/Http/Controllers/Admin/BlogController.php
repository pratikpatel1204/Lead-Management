<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    // ✅ List Blog Categories
    public function blog_categories_list()
    {
        $categories = BlogCategory::latest()->paginate(10);
        return view('admin.blog-categories.list', compact('categories'));
    }

    // ✅ Show Create Form
    public function create_blog_categories()
    {
        return view('admin.blog-categories.create');
    }

    // ✅ Store Category
    public function store_blog_categories(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255|unique:blog_categories,name',
            'status' => 'required|in:Active,Inactive',
        ]);

        try {

            $category = new BlogCategory();
            $category->name = $request->name;
            $category->status = $request->status;
            $category->save();

            return response()->json([
                'status'  => true,
                'message' => 'Blog Category created successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // ✅ Edit View
    public function edit_blog_categories($id)
    {
        $category = BlogCategory::findOrFail($id);
        return view('admin.blog-categories.edit', compact('category'));
    }

    // ✅ Update Category
    public function update_blog_categories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:blog_categories,id',
            'name' => 'required|string|max:255|unique:blog_categories,name,' . $request->id,
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $category = BlogCategory::findOrFail($request->id);
        $category->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Blog Category Updated Successfully'
        ]);
    }

    public function destroy_blog_categories($id)
    {
        $category = BlogCategory::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }
        // Blog::where('category_id', $id)->delete();
        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Blog Category deleted successfully'
        ]);
    }

    // Show all blogs
    public function blog_list()
    {
        $blogs = Blog::with('category')->orderBy('created_at', 'desc')->paginate(6);
        return view('admin.blog.list', compact('blogs'));
    }

    // Show create blog form
    public function create_blog()
    {
        $categories = BlogCategory::where('status', 'Active')->get();
        return view('admin.blog.create', compact('categories'));
    }

    // Store blog via AJAX
    public function blog_store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:Active,Inactive',
        ]);

        try {
            $blog = new Blog();
            $blog->category_id = $request->category_id;
            $blog->title = $request->title;
            $blog->author_name = $request->author_name;
            $blog->short_description = $request->short_description;
            $blog->description = $request->description;
            $blog->status = $request->status;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'blogs/';
                $file->move(public_path($path), $filename);
                $blog->image = $path . $filename;
            }

            $blog->save();

            return response()->json([
                'status' => true,
                'message' => 'Blog created successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Show edit blog form
    public function blog_edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::where('status', 'Active')->get();
        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    // Update blog via AJAX
    public function blog_update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:blogs,id',
            'category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'author_name' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:Active,Inactive',
        ]);

        try {
            $blog = Blog::findOrFail($request->id);
            $blog->category_id = $request->category_id;
            $blog->title = $request->title;
            $blog->author_name = $request->author_name;
            $blog->short_description = $request->short_description;
            $blog->description = $request->description;
            $blog->status = $request->status;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'blogs/';
                $file->move(public_path($path), $filename);
                $blog->image = $path . $filename;
            }

            $blog->save();

            return response()->json([
                'status' => true,
                'message' => 'Blog updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Delete blog via AJAX
    public function blog_destroy($id)
    {
        try {
            $blog = Blog::findOrFail($id);
            $blog->delete();

            return response()->json([
                'success' => true,
                'message' => 'Blog deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }
}
