<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabTestRequest;
use App\Models\LabTestResult;
use App\Models\NotificationTemplate; // Added use statement
use App\Services\SmsService; // Added use statement
use App\Mail\GenericNotificationMail; // Added use statement
use Illuminate\Support\Facades\Mail; // Added use statement
use Illuminate\Http\Request;

class LabResultController extends Controller
{
    public function edit(LabTestRequest $lab_request)
    {
        return view('admin.lab.results.edit', compact('lab_request'));
    }

    public function update(Request $request, LabTestRequest $lab_request)
    {
        // save result...
        foreach ($request->parameter_id as $i => $pid) {
            LabTestResult::updateOrCreate(
                ['request_id' => $lab_request->id, 'parameter_id' => $pid],
                ['value' => $request->value[$i]]
            );
        }

        $lab_request->update(['status' => 'Completed']);

        // get template
        $tpl = NotificationTemplate::where('key','lab_result_ready')->first();

        // Email
        if ($lab_request->patient->email) {
            Mail::to($lab_request->patient->email)->send(
                new GenericNotificationMail(
                    $tpl->title,
                    $tpl->email_body
                )
            );
        }

        // SMS
        if ($lab_request->patient->phone) {
            (new SmsService)->send(
                $lab_request->patient->phone,
                $tpl->sms_body
            );
        }

        return back()->with('success','Results saved & notifications sent.');
    }

    public function pdf(LabTestRequest $lab_request)
    {
        $pdf = \PDF::loadView('admin.lab.results.pdf', compact('lab_request'));
        return $pdf->download('lab-report-'.$lab_request->id.'.pdf');
    }

}