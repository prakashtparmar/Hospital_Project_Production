<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpdVisit;
use App\Models\Patient;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class OpdVisitController extends Controller
{
    private function generateOpdNo()
    {
        $last = OpdVisit::latest()->first();
        $number = $last ? intval(substr($last->opd_no, 3)) + 1 : 1;
        return "OPD" . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function index(Request $request)
    {
        $search = $request->search;

        $visits = OpdVisit::with('patient')
            ->whereHas('patient', function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%$search%")
                  ->orWhere('last_name', 'LIKE', "%$search%")
                  ->orWhere('patient_id', 'LIKE', "%$search%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.opd.index', compact('visits', 'search'));
    }

    public function create()
    {
        $patients = Patient::where('status', 1)->get();
        $departments = Department::where('status', 1)->get();
        $doctors = User::role('Doctor')->get();

        return view('admin.opd.create', compact('patients', 'departments', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'    => 'required',
            'visit_date'    => 'required|date',
        ]);

        OpdVisit::create([
            'opd_no'        => $this->generateOpdNo(),
            'patient_id'    => $request->patient_id,
            'doctor_id'     => $request->doctor_id,
            'department_id' => $request->department_id,
            'visit_date'    => $request->visit_date,
            'symptoms'      => $request->symptoms,
            'diagnosis'     => $request->diagnosis,
            'bp'            => $request->bp,
            'temperature'   => $request->temperature,
            'pulse'         => $request->pulse,
            'weight'        => $request->weight,
            'status'        => $request->status
        ]);

        return redirect()->route('opd.index')->with('success', 'OPD visit created successfully.');
    }

    public function show(OpdVisit $opd)
    {
        return view('admin.opd.show', compact('opd'));
    }

    public function edit(OpdVisit $opd)
    {
        $patients = Patient::where('status', 1)->get();
        $departments = Department::where('status', 1)->get();
        $doctors = User::role('Doctor')->get();

        return view('admin.opd.edit', compact('opd', 'patients', 'departments', 'doctors'));
    }

    public function update(Request $request, OpdVisit $opd)
    {
        $request->validate([
            'patient_id' => 'required',
            'visit_date' => 'required|date',
        ]);

        $opd->update($request->all());

        return redirect()->route('opd.index')->with('success', 'OPD visit updated successfully.');
    }

    public function destroy(OpdVisit $opd)
    {
        $opd->delete();
        return back()->with('success', 'OPD visit deleted.');
    }
}
