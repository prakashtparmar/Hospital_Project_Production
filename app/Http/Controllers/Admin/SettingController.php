<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value','key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // 1. Process all non-file form fields
        foreach ($request->except('_token', 'hospital_logo') as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // 2. Process the hospital_logo file upload if it exists
        if ($request->hasFile('hospital_logo')) {
            $name = time() . '.' . $request->hospital_logo->extension();
            $request->hospital_logo->move(public_path('uploads/logo'), $name);

            Setting::updateOrCreate(
                ['key' => 'hospital_logo'],
                ['value' => $name]
            );
        }

        return back()->with('success','Settings updated');
    }
}