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
    public function __construct()
    {
        $this->middleware('permission:lab-results.view')->only(['edit']);
        $this->middleware('permission:lab-results.edit')->only(['update']);
        $this->middleware('permission:lab-reports.download')->only(['pdf']);
    }

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
        $lab_request->load('items.test.parameters');
        $requestParameterIds = $lab_request->items
            ->flatMap(fn ($item) => $item->test?->parameters ?? collect())
            ->pluck('id')
            ->values();

        if ($requestParameterIds->isEmpty()) {
            return back()->with('error', 'No test parameters found for this lab request.');
        }

        $request->validate([
            'parameter_id' => 'required|array|min:1',
            'parameter_id.*' => 'exists:lab_test_parameters,id',
            'value' => 'nullable|array',
            'value.*' => 'nullable|string|max:255',
        ]);

        $parameterIds = $request->input('parameter_id', []);
        $values = $request->input('value', []);

        foreach ($parameterIds as $i => $pid) {
            if (!$requestParameterIds->contains((int) $pid)) {
                continue;
            }

            LabTestResult::updateOrCreate(
                [
                    'request_id' => $lab_request->id,
                    'parameter_id' => $pid,
                ],
                [
                    'value' => $values[$i] ?? null,
                ]
            );
        }

        $lab_request->update([
            'status' => 'Completed',
        ]);

        // ✅ Notification template (safe)
        $tpl = NotificationTemplate::where('key', 'lab_result_ready')->first();

        // ✅ Email (safe)
        if ($tpl && $lab_request->patient && $lab_request->patient->email) {
            try {
                Mail::to($lab_request->patient->email)->send(
                    new GenericNotificationMail(
                        $tpl->title ?? 'Lab Result Ready',
                        $tpl->email_body ?? ''
                    )
                );
            } catch (\Throwable $e) {
                \Log::error('Failed to send lab result email', [
                    'request_id' => $lab_request->id,
                    'patient_id' => $lab_request->patient->id,
                    'email' => $lab_request->patient->email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // ✅ SMS (safe)
        if ($tpl && $lab_request->patient && $lab_request->patient->phone) {
            try {
                (new SmsService)->send(
                    $lab_request->patient->phone,
                    $tpl->sms_body ?? ''
                );
            } catch (\Throwable $e) {
                \Log::error('Failed to send lab result SMS', [
                    'request_id' => $lab_request->id,
                    'patient_id' => $lab_request->patient->id,
                    'phone' => $lab_request->patient->phone,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // ✅ ✅ REDIRECT TO INDEX PAGE (THIS IS THE FIX)
        return redirect()
            ->route('lab-requests.index')
            ->with('success', 'Results saved & notifications sent.');
    }

    public function pdf(LabTestRequest $lab_request)
    {
        $lab_request->load([
            'patient',
            'doctor',
            'items.test.parameters',
            'results',
        ]);

        $pdf = \PDF::loadView('admin.lab.results.pdf', compact('lab_request'));
        return $pdf->download('lab-report-' . $lab_request->id . '.pdf');
    }
}
