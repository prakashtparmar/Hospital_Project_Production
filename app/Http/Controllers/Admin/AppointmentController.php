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
    public function __construct()
    {
        $this->middleware('permission:appointments.view')->only(['index', 'show']);
        $this->middleware('permission:appointments.create')->only(['create', 'store']);
        $this->middleware('permission:appointments.edit')->only(['edit', 'update']);
        $this->middleware('permission:appointments.delete')->only(['destroy']);
    }

    /**
     * Auto-generate next token number for doctor on a given date.
     */
    private function generateToken($doctor_id, $date)
    {
        $count = Appointment::where('doctor_id', $doctor_id)
            ->where('appointment_date', $date)
            ->count();

        return $count + 1;
    }

    /**
     * Appointment list
     */
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor', 'department'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'asc')
            ->paginate(15);

        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Appointment create form
     */
    public function create()
    {
        $patients = Patient::where('status', 1)->orderBy('first_name')->get();
        $departments = Department::where('status', 1)->orderBy('name')->get();
        $doctors = User::role('Doctor')->orderBy('name')->get();

        return view('admin.appointments.create', compact(
            'patients',
            'departments',
            'doctors'
        ));
    }

    /**
     * Store appointment
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'patient_id'       => 'required|exists:patients,id',
    //         'doctor_id'        => 'required|exists:users,id',
    //         'appointment_date' => 'required|date|after_or_equal:today',
    //         'department_id'    => 'nullable|exists:departments,id',
    //         'reason'           => 'nullable|string',
    //     ]);

    //     // Check doctor schedule availability for the selected day
    //     $day = Carbon::parse($request->appointment_date)->format('l');

    //     $schedule = DoctorSchedule::where('doctor_id', $request->doctor_id)
    //         ->where('day', $day)
    //         ->where('status', 1)
    //         ->first();

    //     if (! $schedule) {
    //         return back()
    //             ->withErrors(['doctor_id' => 'Doctor is not available on this day.'])
    //             ->withInput();
    //     }

    //     // Generate next token number
    //     $token = $this->generateToken($request->doctor_id, $request->appointment_date);

    //     Appointment::create([
    //         'patient_id'       => $request->patient_id,
    //         'doctor_id'        => $request->doctor_id,
    //         'department_id'    => $request->department_id,
    //         'appointment_date' => $request->appointment_date,
    //         'appointment_time' => $schedule->start_time ?? null,
    //         'token_no'         => $token,
    //         'reason'           => $request->reason,
    //         'status'           => 'Pending',
    //     ]);

    //     return redirect()->route('appointments.index')
    //                      ->with('success', 'Appointment booked successfully.');
    // }

    /**
     * Show appointment details
     */

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',  // NEW
            'department_id' => 'nullable|exists:departments,id',
            'reason' => 'nullable|string',
        ]);

        // Check doctor availability
        $day = Carbon::parse($request->appointment_date)->format('l');

        $schedule = DoctorSchedule::where('doctor_id', $request->doctor_id)
            ->where('day', $day)
            ->where('status', 1)
            ->first();

        if (!$schedule) {
            return back()
                ->withErrors(['doctor_id' => 'Doctor is not available on this day.'])
                ->withInput();
        }

        // ❗ CHECK #1: Prevent duplicate timeslot booking for doctor
        $duplicate = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->exists();

        if ($duplicate) {
            return back()
                ->withErrors(['appointment_time' => 'This time slot is already booked.'])
                ->withInput();
        }

        // ❗ CHECK #2: Prevent patient from booking twice with same doctor & date
        $patientDuplicate = Appointment::where('patient_id', $request->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->exists();

        if ($patientDuplicate) {
            return back()
                ->withErrors(['patient_id' => 'This patient already has an appointment with this doctor on the selected date.'])
                ->withInput();
        }

        // ❗ CHECK #3: Prevent patient from having ANY OTHER appointment at the same date & time (NEW)
        $patientTimeConflict = Appointment::where('patient_id', $request->patient_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->exists();

        if ($patientTimeConflict) {
            return back()
                ->withErrors(['appointment_time' => 'This patient already has another appointment at the same time.'])
                ->withInput();
        }

        // Token number generation
        $token = $this->generateToken($request->doctor_id, $request->appointment_date);

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'department_id' => $request->department_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time, // NEW
            'token_no' => $token,
            'reason' => $request->reason,
            'status' => 'Pending',
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment booked successfully.');
    }



    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Edit appointment
     */
    public function edit(Appointment $appointment)
    {
        $patients = Patient::where('status', 1)->get();
        $departments = Department::where('status', 1)->get();
        $doctors = User::role('Doctor')->get();

        return view('admin.appointments.edit', compact(
            'appointment',
            'patients',
            'departments',
            'doctors'
        ));
    }

    /**
     * Update appointment
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'required|in:Pending,CheckedIn,InConsultation,Completed,Cancelled',
            'reason' => 'nullable|string',
        ]);

        $appointment->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'department_id' => $request->department_id,
            'appointment_date' => $request->appointment_date,
            'reason' => $request->reason,
            'status' => $request->status,
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    /**
     * Soft delete
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return back()->with('success', 'Appointment cancelled.');
    }

    public function getAvailableSlots(Request $request)
    {
        $doctorId = $request->doctor_id;
        $date = $request->appointment_date;

        if (!$doctorId || !$date) {
            return response()->json(['slots' => []]);
        }

        $day = Carbon::parse($date)->format('l');

        $schedule = DoctorSchedule::where('doctor_id', $doctorId)
            ->where('day', $day)
            ->where('status', 1)
            ->first();

        if (!$schedule) {
            return response()->json(['slots' => []]);
        }

        $start = Carbon::parse($schedule->start_time);
        $end = Carbon::parse($schedule->end_time);
        $duration = $schedule->slot_duration;

        $slots = [];

        while ($start < $end) {
            $time = $start->format('H:i');

            $exists = Appointment::where('doctor_id', $doctorId)
                ->where('appointment_date', $date)
                ->where('appointment_time', $start->format('H:i:s'))
                ->exists();

            if (!$exists) {
                $slots[] = $time;
            }

            $start->addMinutes($duration);
        }

        return response()->json(['slots' => $slots]);
    }

}
