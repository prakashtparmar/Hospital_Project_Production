<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RadiologyTest;
use App\Models\RadiologyRequest;
use App\Models\RadiologyRequestItem;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class RadiologyRequestController extends Controller
{
    public function __construct()
    {
        // View radiology requests
        $this->middleware('permission:radiology-requests.view')->only(['index']);

        // Create radiology request
        $this->middleware('permission:radiology-requests.create')->only(['create', 'store']);

        // Start radiology test
        $this->middleware('permission:radiology-tests.start')->only(['start']);
    }

    public function index()
    {
        $requests = RadiologyRequest::with([
                'patient',
                'doctor',
                'items.test'
            ])
            ->latest()
            ->paginate(15);

        return view('admin.radiology.requests.index', compact('requests'));
    }

    public function create()
    {
        return view('admin.radiology.requests.create', [
            'patients' => Patient::orderBy('first_name')->get(),
            'doctors'  => User::role('Doctor')->orderBy('name')->get(),
            'tests'    => RadiologyTest::where('status', 1)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        // ✅ Validation (doctor optional)
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id'  => 'nullable|exists:users,id',
            'test_id'    => 'required|array|min:1',
            'test_id.*'  => 'exists:radiology_tests,id',
        ]);

        $req = RadiologyRequest::create([
            'patient_id' => $request->patient_id,
            'doctor_id'  => $request->doctor_id,
            'opd_id'     => $request->opd_id,
            'ipd_id'     => $request->ipd_id,
            'status'     => 'Pending',
        ]);

        foreach ($request->test_id as $testId) {
            RadiologyRequestItem::create([
                'request_id' => $req->id,
                'test_id'    => $testId,
            ]);
        }

        return redirect()
            ->route('radiology-requests.index')
            ->with('success', 'Radiology request created successfully.');
    }

    public function start(RadiologyRequest $radiology_request)
    {
        // ✅ Safety check
        if ($radiology_request->status !== 'Pending') {
            return back()->with('error', 'Radiology test already started.');
        }

        $radiology_request->update([
            'status' => 'In Progress',
        ]);

        return back()->with('success', 'Radiology test started.');
    }
}
