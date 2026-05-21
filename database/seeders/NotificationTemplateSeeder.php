<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NotificationTemplate;

class NotificationTemplateSeeder extends Seeder
{
    public function run()
    {
        NotificationTemplate::firstOrCreate(
            ['key' => 'lab_result_ready'],
            [
                'title'       => 'Lab Test Results Ready',
                'email_body'  => 'Dear Patient, your lab test results are ready.',
                'sms_body'    => 'Your lab test report is ready. Please contact hospital.'
            ]
        );
    }
}
