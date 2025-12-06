<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorSchedule;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:doctor-schedule.view')->only(['index', 'show']);
        $this->middleware('permission:doctor-schedule.create')->only(['create', 'store']);
        $this->middleware('permission:doctor-schedule.edit')->only(['edit', 'update']);
        $this->middleware('permission:doctor-schedule.delete')->only(['destroy']);
    }

    public function index()
    {
        $schedules = DoctorSchedule::with(['doctor', 'department'])
            ->orderBy('doctor_id')
            ->paginate(15);

        return view('admin.doctor_schedule.index', compact('schedules'));
    }

    public function create()
    {
        $doctors = User::whereHas('roles', function ($q) {
            $q->where('name', 'Doctor');
        })->get();

        return view('admin.doctor_schedule.create', [
            'doctors' => $doctors,
            'departments' => Department::all(),
            'days' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id'  => 'required',
            'day'        => 'required',
            'start_time' => 'required',
            'end_time'   => 'required'
        ]);

        DoctorSchedule::create($request->all());

        /**
         * 🔥 Smart Redirect
         * If request was sent from Doctor listing modal → stay on same page
         */
        if ($request->has('redirect_back') && $request->redirect_back == 1) {
            return back()->with('success', 'Schedule added successfully.');
        }

        return redirect()->route('doctor-schedule.index')
                         ->with('success', 'Schedule added successfully.');
    }

    public function edit(DoctorSchedule $doctor_schedule)
    {
        $doctors = User::whereHas('roles', function ($q) {
            $q->where('name', 'Doctor');
        })->get();

        return view('admin.doctor_schedule.edit', [
            'schedule'    => $doctor_schedule,
            'doctors'     => $doctors,
            'departments' => Department::all(),
            'days'        => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']
        ]);
    }

    public function update(Request $request, DoctorSchedule $doctor_schedule)
    {
        $request->validate([
            'doctor_id'  => 'required',
            'day'        => 'required',
            'start_time' => 'required',
            'end_time'   => 'required'
        ]);

        $doctor_schedule->update($request->all());

        /**
         * 🔥 Smart Redirect
         * If update came from Doctors listing modal → stay on same page
         */
        if ($request->has('redirect_back') && $request->redirect_back == 1) {
            return back()->with('success', 'Schedule updated successfully.');
        }

        return redirect()->route('doctor-schedule.index')
                         ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(DoctorSchedule $doctor_schedule)
    {
        $doctor_schedule->delete();

        return back()->with('success', 'Schedule deleted.');
    }
}
