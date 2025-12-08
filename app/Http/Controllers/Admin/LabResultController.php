<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabTestRequest;
use App\Models\LabTestResult;
use App\Models\NotificationTemplate;
use App\Services\SmsService;
use App\Mail\GenericNotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class LabResultController extends Controller
{
    public function edit(LabTestRequest $lab_request)
{
    $lab_request->load([
        'patient',
        'items.test.parameters',
        'results'
    ]);

    return view('admin.lab.results.edit', compact('lab_request'));
}


    public function update(Request $request, LabTestRequest $lab_request)
    {
        // ✅ Save results
        foreach ($request->parameter_id as $i => $pid) {
            LabTestResult::updateOrCreate(
                [
                    'request_id'   => $lab_request->id,
                    'parameter_id' => $pid
                ],
                [
                    'value' => $request->value[$i] ?? null
                ]
            );
        }

        // ✅ Mark request completed
        $lab_request->update([
            'status' => 'Completed'
        ]);

        // ✅ Notification template (safe)
        $tpl = NotificationTemplate::where('key', 'lab_result_ready')->first();

        // ✅ Email (safe)
        if ($tpl && $lab_request->patient && $lab_request->patient->email) {
            Mail::to($lab_request->patient->email)->send(
                new GenericNotificationMail(
                    $tpl->title ?? 'Lab Result Ready',
                    $tpl->email_body ?? ''
                )
            );
        }

        // ✅ SMS (safe)
        if ($tpl && $lab_request->patient && $lab_request->patient->phone) {
            (new SmsService)->send(
                $lab_request->patient->phone,
                $tpl->sms_body ?? ''
            );
        }

        // ✅ ✅ REDIRECT TO INDEX PAGE (THIS IS THE FIX)
        return redirect()
            ->route('lab-requests.index')
            ->with('success', 'Results saved & notifications sent.');
    }

    public function pdf(LabTestRequest $lab_request)
    {
        $pdf = \PDF::loadView('admin.lab.results.pdf', compact('lab_request'));
        return $pdf->download('lab-report-' . $lab_request->id . '.pdf');
    }
}
