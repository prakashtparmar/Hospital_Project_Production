<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Department;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private function generatePatientId()
    {
        $last = Patient::latest()->first();
        $number = $last ? intval(substr($last->patient_id, 3)) + 1 : 1;
        return "PAT" . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function index(Request $request)
    {
        $search = $request->search;

        $patients = Patient::where(function ($q) use ($search) {
            $q->where('first_name', 'LIKE', "%$search%")
              ->orWhere('last_name', 'LIKE', "%$search%")
              ->orWhere('patient_id', 'LIKE', "%$search%");
        })
        ->latest()
        ->paginate(10);

        return view('admin.patients.index', compact('patients', 'search'));
    }

    public function create()
    {
        $departments = Department::where('status', 1)->get();
        return view('admin.patients.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'   => 'required',
            'gender'       => 'required',
            'department_id'=> 'nullable|exists:departments,id'
        ]);

        Patient::create([
            'patient_id'   => $this->generatePatientId(),
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'gender'       => $request->gender,
            'age'          => $request->age,
            'phone'        => $request->phone,
            'email'        => $request->email,
            'address'      => $request->address,
            'department_id'=> $request->department_id,
            'status'       => $request->status
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient registered successfully.');
    }

    public function show(Patient $patient)
    {
        return view('admin.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $departments = Department::where('status', 1)->get();
        return view('admin.patients.edit', compact('patient', 'departments'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'first_name'   => 'required',
            'gender'       => 'required',
            'department_id'=> 'nullable|exists:departments,id'
        ]);

        $patient->update($request->all());

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return back()->with('success', 'Patient removed.');
    }
}
