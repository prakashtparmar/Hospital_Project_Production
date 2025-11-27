<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorSchedule;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    public function index()
    {
        $schedules = DoctorSchedule::with('doctor', 'department')
            ->orderBy('doctor_id')
            ->paginate(15);

        return view('admin.doctor_schedule.index', compact('schedules'));
    }

    public function create()
    {
        return view('admin.doctor_schedule.create', [
            'doctors' => User::role('Doctor')->get(),
            'departments' => Department::all(),
            'days' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        DoctorSchedule::create($request->all());

        return redirect()->route('doctor-schedule.index')
                         ->with('success', 'Schedule added successfully.');
    }

    public function edit(DoctorSchedule $doctor_schedule)
    {
        return view('admin.doctor_schedule.edit', [
            'schedule' => $doctor_schedule,
            'doctors' => User::role('Doctor')->get(),
            'departments' => Department::all(),
            'days' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']
        ]);
    }

    public function update(Request $request, DoctorSchedule $doctor_schedule)
    {
        $request->validate([
            'doctor_id' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        $doctor_schedule->update($request->all());

        return redirect()->route('doctor-schedule.index')
                         ->with('success', 'Schedule updated.');
    }

    public function destroy(DoctorSchedule $doctor_schedule)
    {
        $doctor_schedule->delete();
        return back()->with('success', 'Schedule deleted.');
    }
}
