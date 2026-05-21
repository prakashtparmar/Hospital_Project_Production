<?php

namespace App\Services;

use App\Models\NotificationSetting;
use Illuminate\Support\Facades\Http;

class SmsService
{
    public function send($mobile, $message)
    {
        // ✅ fetch settings safely
        $setting = NotificationSetting::first();

        // ✅ NO SETTINGS → exit safely
        if (!$setting) {
            return false;
        }

        // ✅ SMS not configured → exit safely
        if (
            empty($setting->sms_gateway_url) ||
            empty($setting->sms_api_key) ||
            empty($setting->sms_sender_id)
        ) {
            return false;
        }

        // ✅ send SMS
        try {
            $response = Http::get($setting->sms_gateway_url, [
                'apikey'  => $setting->sms_api_key,
                'sender'  => $setting->sms_sender_id,
                'numbers' => $mobile,
                'message' => $message,
            ]);

            return $response->body();
        } catch (\Exception $e) {
            return false;
        }
    }
}
