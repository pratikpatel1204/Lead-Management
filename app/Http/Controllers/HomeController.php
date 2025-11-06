<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\ContactSetting;
use App\Models\Inquery;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('status', 'Active')->get();
        $services = Service::latest()->take(4)->get();
        $abouts = AboutUs::first();
        $contact = ContactSetting::first();
        $testimonials = Testimonial::latest()->get();
        $servicecategory = ServiceCategory::latest()->get();
        $teams = Team::latest()->take(3)->get();
        $blogs = Blog::where('status', 'Active')->latest()->take(3)->get();
        $choose_us = WhyChooseUs::first();
        return view('front.index', compact('banners', 'services', 'abouts', 'testimonials', 'teams', 'blogs', 'contact', 'servicecategory', 'choose_us'));
    }
    public function about_us()
    {
        $abouts = AboutUs::first();
        $services = Service::latest()->take(4)->get();
        $testimonials = Testimonial::latest()->get();
        $teams = Team::latest()->take(3)->get();
        return view('front.about_us', compact('abouts', 'services', 'testimonials', 'teams'));
    }
    public function our_team()
    {
        $teams = Team::latest()->get();
        return view('front.team', compact('teams'));
    }
    public function blog()
    {
        $allBlogs = Blog::where('status', 'Active')->latest()->paginate(3);
        $recentBlogs = Blog::where('status', 'Active')->latest()->take(3)->get();
        $blogCategories = BlogCategory::all();
        return view('front.blog', compact('allBlogs', 'recentBlogs', 'blogCategories'));
    }
    public function blogByCategory($name)
    {
        $category = BlogCategory::where('slug', $name)->firstOrFail();
        $allBlogs = Blog::where('status', 'Active')
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(3);
        $recentBlogs = Blog::where('status', 'Active')->latest()->take(3)->get();
        $blogCategories = BlogCategory::all();

        return view('front.blog', compact('allBlogs', 'recentBlogs', 'blogCategories', 'category'));
    }
    public function contact_us()
    {
        $contact = ContactSetting::first();
        return view('front.contact_us', compact('contact'));
    }
    public function blogDetails($slug)
    {
        $blog = Blog::where('slug', $slug)->where('status', 'Active')->firstOrFail();
        $recentBlogs = Blog::where('status', 'Active')->latest()->take(3)->get();
        $blogCategories = BlogCategory::all();
        return view('front.blog_details', compact('blog', 'recentBlogs', 'blogCategories'));
    }
    public function services()
    {
        $services = Service::latest()->get();
        $testimonials = Testimonial::latest()->get();
        return view('front.service', compact('services', 'testimonials'));
    }
    public function serviceDetails($title)
    {
        $service = Service::where('slug', $title)->firstOrFail();
        $serviceCategories = ServiceCategory::all();

        return view('front.service_details', compact('service', 'serviceCategories'));
    }
    public function serviceByCategory($slug)
    {
        $category = ServiceCategory::where('slug', $slug)->firstOrFail();
        $services = Service::where('category_id', $category->id)->latest()->get();
        $testimonials = Testimonial::latest()->get();

        return view('front.service', compact('category', 'services', 'testimonials'));
    }

    public function contactSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'message' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        Inquery::create($request->only('name', 'email', 'message'));

        return response()->json([
            'status' => 'success',
            'message' => 'Thank you for contacting us! We will get back to you soon.',
        ]);
    }
    public function contact_inquery(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:1000',
        ]);

        Inquery::create($validated);

        return response()->json(['status' => 'success', 'message' => 'Your inquiry has been submitted successfully!']);
    }
    public function newsletter_submit(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:inqueries,email',
        ]);

        Inquery::create($validated);

        return response()->json(['status' => 'success', 'message' => 'Thank you for subscribing!']);
    }
}
