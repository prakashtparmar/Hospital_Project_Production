<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $fillable = [
        'smtp_host','smtp_port','smtp_user','smtp_pass','smtp_encryption',
        'sms_api_key','sms_sender_id','sms_gateway_url'
    ];
}
