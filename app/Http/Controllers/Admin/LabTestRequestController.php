<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabTest;
use App\Models\LabTestRequest;
use App\Models\LabTestRequestItem;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class LabTestRequestController extends Controller
{
    public function index()
    {
        $requests = LabTestRequest::with('patient')->latest()->paginate(15);
        return view('admin.lab.requests.index', compact('requests'));
    }

    public function create()
    {
        return view('admin.lab.requests.create', [
            'patients' => Patient::all(),
            'doctors' => User::role('Doctor')->get(),
            'tests' => LabTest::all()
        ]);
    }

    public function store(Request $request)
    {
        $req = LabTestRequest::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'opd_id' => $request->opd_id,
            'ipd_id' => $request->ipd_id
        ]);

        foreach ($request->test_id as $t) {
            LabTestRequestItem::create([
                'request_id' => $req->id,
                'test_id' => $t
            ]);
        }

        return redirect()->route('lab-requests.index')->with('success', 'Test request created.');
    }

    //Sample Collection Funtion

    public function collectSample(LabTestRequest $lab_request)
    {
        $lab_request->update(['status' => 'Sample Collected']);
        return back()->with('success', 'Sample collected.');
    }

}
