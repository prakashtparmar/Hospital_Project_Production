<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Models\Department;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    private function generateToken($doctor_id, $date)
    {
        $count = Appointment::where('doctor_id', $doctor_id)
                            ->where('appointment_date', $date)
                            ->count();
        return $count + 1;
    }

    public function index()
    {
        $appointments = Appointment::with('patient','doctor','department')
            ->orderBy('appointment_date','desc')
            ->orderBy('appointment_time','asc')
            ->paginate(15);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients    = Patient::all();
        $departments = Department::all();
        $doctors     = User::role('Doctor')->get();

        return view('admin.appointments.create', compact(
            'patients','departments','doctors'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'       => 'required',
            'doctor_id'        => 'required',
            'appointment_date' => 'required|date'
        ]);

        // Validate doctor availability for the selected day
        $day = Carbon::parse($request->appointment_date)->format('l');

        $schedule = DoctorSchedule::where('doctor_id', $request->doctor_id)
            ->where('day', $day)
            ->where('status', 1)
            ->first();

        if (! $schedule) {
            return back()->withErrors(['doctor_id' => 'Doctor is not available on this day.']);
        }

        // Token generation
        $token = $this->generateToken($request->doctor_id, $request->appointment_date);

        Appointment::create([
            'patient_id'       => $request->patient_id,
            'doctor_id'        => $request->doctor_id,
            'department_id'    => $request->department_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $schedule->start_time ?? null,
            'token_no'         => $token,
            'reason'           => $request->reason,
        ]);

        return redirect()->route('appointments.index')
                         ->with('success','Appointment booked successfully.');
    }

    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients    = Patient::all();
        $departments = Department::all();
        $doctors     = User::role('Doctor')->get();

        return view('admin.appointments.edit', compact(
            'appointment','patients','departments','doctors'
        ));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $appointment->update($request->all());
        return redirect()->route('appointments.index')->with('success','Updated.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return back()->with('success','Appointment cancelled.');
    }
}
