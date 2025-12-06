<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($key, $default = null) {
        $row = Setting::where('key', $key)->first();
        return $row ? $row->value : $default;
    }
}
