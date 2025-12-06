<?php

namespace App\Services;

use App\Models\NotificationSetting;
use Illuminate\Support\Facades\Http;

class SmsService
{
    public function send($mobile, $message)
    {
        $setting = NotificationSetting::first();

        if (!$setting->sms_gateway_url) {
            return false;
        }

        $response = Http::get($setting->sms_gateway_url, [
            'apikey' => $setting->sms_api_key,
            'sender' => $setting->sms_sender_id,
            'numbers' => $mobile,
            'message' => $message
        ]);

        return $response->body();
    }
}
