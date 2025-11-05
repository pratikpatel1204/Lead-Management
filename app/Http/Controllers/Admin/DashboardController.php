<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\ContactSetting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function about_us_edit()
    {
        $about = AboutUs::first();
        return view('admin.aboutus', compact('about'));
    }
    public function about_us_update(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'main_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'second_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024', 
        ]);
        $about = AboutUs::first() ?? new AboutUs;
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $filename = 'main_' . time() . '.' . $file->getClientOriginalExtension();
            $path = 'about/';
            $file->move(public_path($path), $filename);
            if (!empty($about->main_image) && file_exists(public_path($about->main_image))) {
                unlink(public_path($about->main_image));
            }
            $data['main_image'] = $path . $filename;
        }
        if ($request->hasFile('second_image')) {
            $file = $request->file('second_image');
            $filename = 'second_' . time() . '.' . $file->getClientOriginalExtension();
            $path = 'about/';
            $file->move(public_path($path), $filename);
            if (!empty($about->second_image) && file_exists(public_path($about->second_image))) {
                unlink(public_path($about->second_image));
            }
            $data['second_image'] = $path . $filename;
        }    

        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $about->updateOrCreate(['id' => $about->id], $data);
        return response()->json([
            'status' => true,
            'message' => 'About Us updated successfully'
        ]);
    }
    public function contact_settings()
    {
        $contact = ContactSetting::first();
        return view('admin.contact_settings', compact('contact'));
    }
    public function contact_settings_update(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $contact = ContactSetting::first() ?? new ContactSetting();

        $contact->updateOrCreate(
            ['id' => $contact->id ?? null],
            $request->only([
                'email',
                'phone',
                'address',
                'map_link',
                'facebook',
                'twitter',
                'linkedin',
                'instagram'
            ])
        );

        return response()->json(['status' => true, 'message' => 'Contact settings saved successfully']);
    }
}
