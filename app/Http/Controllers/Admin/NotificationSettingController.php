<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationSetting;
use Illuminate\Http\Request;

class NotificationSettingController extends Controller
{
    public function index()
    {
        $setting = NotificationSetting::first();
        return view('admin.notifications.settings', compact('setting'));
    }

    public function update(Request $request)
    {
        NotificationSetting::first()->update($request->all());
        return back()->with('success','Settings updated.');
    }
}
