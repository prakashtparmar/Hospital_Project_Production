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

    private function generateToken($doctor_id, $date)
    {
        return Appointment::where('doctor_id', $doctor_id)
            ->where('appointment_date', $date)
            ->count() + 1;
    }

    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor', 'department'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'asc')
            ->paginate(15);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function create(Request $request)
    {
        $patients = Patient::select('id', 'patient_id', 'first_name', 'middle_name', 'last_name')
            ->orderBy('first_name')->get();

        $doctors = User::role('Doctor')->with('doctorProfile')->get();
        $departments = Department::where('status', 1)->get();

        return view('admin.appointments.create', [
            'patients' => $patients,
            'doctors' => $doctors,
            'departments' => $departments,
            'selectedPatient' => $request->selected_patient
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'department_id'    => 'nullable|exists:departments,id',
            'reason'           => 'nullable|string',
        ]);

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

        // Fix: Always compare time with proper H:i:s format
        $slot = Carbon::parse($request->appointment_time)->format('H:i:s');

        $duplicate = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $slot)
            ->exists();

        if ($duplicate) {
            return back()
                ->withErrors(['appointment_time' => 'This time slot is already booked.'])
                ->withInput();
        }

        $patientDuplicate = Appointment::where('patient_id', $request->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->exists();

        if ($patientDuplicate) {
            return back()
                ->withErrors(['patient_id' => 'This patient already has an appointment with this doctor on this date.'])
                ->withInput();
        }

        $token = $this->generateToken($request->doctor_id, $request->appointment_date);

        Appointment::create([
            'patient_id'       => $request->patient_id,
            'doctor_id'        => $request->doctor_id,
            'department_id'    => $request->department_id,
            'appointment_date' => Carbon::parse($request->appointment_date)->format('Y-m-d'),
            'appointment_time' => $slot,
            'token_no'         => $token,
            'reason'           => $request->reason,
            'status'           => 'Pending',
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment booked successfully.');
    }

    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::select('id', 'patient_id', 'first_name', 'middle_name', 'last_name', 'status')
            ->orderBy('first_name')->get();

        $departments = Department::where('status', 1)->get();
        $doctors = User::role('Doctor')->get();

        return view('admin.appointments.edit', compact('appointment', 'patients', 'departments', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',   // FIX MISSING VALIDATION
            'department_id'    => 'nullable|exists:departments,id',
            'status'           => 'required|in:Pending,CheckedIn,InConsultation,Completed,Cancelled',
            'reason'           => 'nullable|string',
        ]);

        $slot = Carbon::parse($request->appointment_time)->format('H:i:s');

        $appointment->update([
            'patient_id'       => $request->patient_id,
            'doctor_id'        => $request->doctor_id,
            'department_id'    => $request->department_id,
            'appointment_date' => Carbon::parse($request->appointment_date)->format('Y-m-d'),
            'appointment_time' => $slot,
            'reason'           => $request->reason,
            'status'           => $request->status,
        ]);

        /* Keep Consultation synced */
        if ($appointment->consultation) {

            $map = [
                'Completed'      => 'completed',
                'InConsultation' => 'in_progress',
                'Cancelled'      => 'cancelled'
            ];

            if (isset($map[$appointment->status])) {
                $appointment->consultation->update(['status' => $map[$appointment->status]]);
            }
        }

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

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

            $timeFormatted = $start->format('H:i');
            $timeFull = $start->format('H:i:s');

            $exists = Appointment::where('doctor_id', $doctorId)
                ->where('appointment_date', $date)
                ->where('appointment_time', $timeFull)
                ->exists();

            if (!$exists) {
                $slots[] = $timeFormatted;
            }

            $start->addMinutes($duration);
        }

        return response()->json(['slots' => $slots]);
    }

    public function convertToOpd(Appointment $appointment)
    {
        if (!$appointment->patient_id || !$appointment->doctor_id) {
            return back()->with('error', 'Missing patient or doctor details.');
        }

        \App\Models\OpdVisit::create([
            'opd_no'        => app(\App\Http\Controllers\Admin\OpdVisitController::class)->generateOpdNo(),
            'patient_id'    => $appointment->patient_id,
            'doctor_id'     => $appointment->doctor_id,
            'department_id' => $appointment->department_id,
            'visit_date'    => Carbon::parse($appointment->appointment_date),
            'symptoms'      => $appointment->reason,
            'status'        => 1,
        ]);

        $appointment->update(['status' => 'CheckedIn']);

        return redirect()->route('opd.index')
            ->with('success', 'Appointment successfully converted to OPD visit.');
    }
}
