<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RadiologyReport;
use App\Models\RadiologyRequest;
use Illuminate\Http\Request;

class RadiologyReportController extends Controller
{
    public function edit(RadiologyRequest $radiology_request)
    {
        $radiology_request->load(['patient', 'doctor', 'items.test', 'report']);

        return view('admin.radiology.reports.edit', compact('radiology_request'));
    }

    public function update(Request $request, RadiologyRequest $radiology_request)
    {
        if ($radiology_request->status === 'Completed') {
            return redirect()->route('radiology-requests.index')
                ->with('error', 'Completed radiology reports cannot be edited.');
        }

        $request->validate([
            'report' => 'required|string',
            'impression' => 'nullable|string',
        ]);

        RadiologyReport::updateOrCreate(
            ['request_id' => $radiology_request->id],
            [
                'report' => $request->report,
                'impression' => $request->impression
            ]
        );

        $radiology_request->update(['status' => 'Completed']);

        return redirect()->route('radiology-requests.index')->with('success','Report Saved.');
    }

    //Print PDF Report
    public function pdf(RadiologyRequest $radiology_request)
{
    $radiology_request->load(['patient', 'doctor', 'items.test', 'report']);

    $pdf = \PDF::loadView('admin.radiology.reports.pdf', compact('radiology_request'));
    return $pdf->download('radiology-report-'.$radiology_request->id.'.pdf');
}

}
