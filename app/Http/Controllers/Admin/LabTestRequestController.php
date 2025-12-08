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
    public function __construct()
{
    // View requests list
    $this->middleware('permission:lab-requests.view')->only(['index']);

    // Create request
    $this->middleware('permission:lab-requests.create')->only(['create', 'store']);

    // Collect sample
    $this->middleware('permission:lab-samples.collect')->only(['collectSample']);
}

    public function index()
    {
        $requests = LabTestRequest::with(['patient', 'doctor'])
            ->latest()
            ->paginate(15);

        return view('admin.lab.requests.index', compact('requests'));
    }

    public function create()
    {
        return view('admin.lab.requests.create', [
            'patients' => Patient::orderBy('first_name')->get(),
            'doctors'  => User::role('Doctor')->get(),
            'tests'    => LabTest::where('status', 1)->get(),
        ]);
    }

    public function store(Request $request)
    {
        // ✅ Doctor is OPTIONAL (matches Blade + requirement)
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id'  => 'nullable|exists:users,id',
            'test_id'    => 'required|array|min:1',
            'test_id.*'  => 'exists:lab_tests,id',
        ]);

        $req = LabTestRequest::create([
            'patient_id' => $request->patient_id,
            'doctor_id'  => $request->doctor_id, // can be null ✅
            'opd_id'     => $request->opd_id,
            'ipd_id'     => $request->ipd_id,
        ]);

        foreach ($request->test_id as $t) {
            LabTestRequestItem::create([
                'request_id' => $req->id,
                'test_id'    => $t,
            ]);
        }

        return redirect()
            ->route('lab-requests.index')
            ->with('success', 'Test request created.');
    }

    public function collectSample(LabTestRequest $lab_request)
    {
        $lab_request->update([
            'status' => 'Sample Collected',
        ]);

        return back()->with('success', 'Sample collected.');
    }
}
