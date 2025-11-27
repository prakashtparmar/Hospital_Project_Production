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
    public function index()
    {
        $requests = RadiologyRequest::with('patient')->latest()->paginate(15);
        return view('admin.radiology.requests.index', compact('requests'));
    }

    public function create()
    {
        return view('admin.radiology.requests.create', [
            'patients' => Patient::all(),
            'doctors' => User::role('Doctor')->get(),
            'tests' => RadiologyTest::all()
        ]);
    }

    public function store(Request $request)
    {
        $req = RadiologyRequest::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'opd_id' => $request->opd_id,
            'ipd_id' => $request->ipd_id
        ]);

        foreach ($request->test_id as $t) {
            RadiologyRequestItem::create([
                'request_id' => $req->id,
                'test_id' => $t
            ]);
        }

        return redirect()->route('radiology-requests.index')->with('success','Request Created.');
    }

    public function start(RadiologyRequest $radiology_request)
    {
        $radiology_request->update(['status' => 'In Progress']);
        return back()->with('success','Test Started.');
    }
}
