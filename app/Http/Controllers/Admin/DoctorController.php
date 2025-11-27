<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\DoctorProfile;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = User::role('Doctor')->with('doctorProfile')->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create', [
            'departments' => Department::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'department_id'  => 'nullable',
            'specialization' => 'required'
        ]);

        DoctorProfile::create($request->all());

        return redirect()->route('doctors.index')->with('success', 'Doctor profile added.');
    }

    public function edit($id)
    {
        $doctor = DoctorProfile::where('user_id', $id)->firstOrFail();
        return view('admin.doctors.edit', [
            'doctor' => $doctor,
            'departments' => Department::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $doctor = DoctorProfile::where('user_id', $id)->firstOrFail();

        $doctor->update($request->all());

        return redirect()->route('doctors.index')->with('success', 'Doctor updated.');
    }
}
