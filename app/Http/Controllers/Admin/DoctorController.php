<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\DoctorProfile;
use Illuminate\Http\Request;


class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:doctors.view')->only(['index', 'show']);
        $this->middleware('permission:doctors.create')->only(['create', 'store']);
        $this->middleware('permission:doctors.edit')->only(['edit', 'update']);
        $this->middleware('permission:doctors.delete')->only(['destroy']);
    }

    public function index()
    {
        // Prevent crash if doctorProfile is missing
        $doctors = User::role('Doctor')
            ->with('doctorProfile')
            ->whereHas('doctorProfile')
            ->paginate(10);

        // REQUIRED for Add Doctor Modal (NO IMPACT on existing logic)
        $users = User::doesntHave('doctorProfile')->get();
        $departments = Department::all();

        return view('admin.doctors.index', compact('doctors', 'users', 'departments'));
    }




    public function create()
    {
        return view('admin.doctors.create', [
            'departments' => Department::all(),
            'users' => User::doesntHave('doctorProfile')->get() // FIXED
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'department_id' => 'nullable',
            'specialization' => 'required'
        ]);

        DoctorProfile::create($request->all());

        // Assign Doctor Role
        $user = User::find($request->user_id);
        if (!$user->hasRole('Doctor')) {
            $user->assignRole('Doctor');
        }

        return redirect()->route('doctors.index')->with('success', 'Doctor profile added.');
    }


    public function show($id)
    {
        $doctor = DoctorProfile::findOrFail($id);
        return view('admin.doctors.show', compact('doctor'));
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

    public function destroy($id)
{
    // Find doctor profile by USER ID
    $doctor = DoctorProfile::where('user_id', $id)->firstOrFail();
    $doctor->delete();

    return redirect()->route('doctors.index')->with('success', 'Doctor deleted.');
}

}
