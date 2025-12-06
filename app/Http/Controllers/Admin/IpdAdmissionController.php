<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IpdAdmission;
use App\Models\Patient;
use App\Models\Ward;
use App\Models\Room;
use App\Models\Bed;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class IpdAdmissionController extends Controller
{
    private function generateIpdNo()
    {
        $last = IpdAdmission::latest()->first();
        $number = $last ? intval(substr($last->ipd_no, 3)) + 1 : 1;
        return "IPD" . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        $search = null;

        $admissions = IpdAdmission::with('patient', 'doctor', 'ward', 'room', 'bed')
            ->latest()
            ->paginate(10);

        return view('admin.ipd.index', compact('admissions', 'search'));
    }

    public function create()
    {
        return view('admin.ipd.create', [
            'patients'     => Patient::all(),
            'departments'  => Department::all(),

            // 🔥 FIX: load doctorProfile + department
            'doctors'      => User::role('Doctor')
                                ->with('doctorProfile.department')
                                ->get(),

            'wards'        => Ward::all(),
            'rooms'        => Room::all(),
            'beds'         => Bed::where('is_occupied', 0)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'        => 'required|exists:patients,id',
            'doctor_id'         => 'nullable|exists:users,id',
            'department_id'     => 'nullable|exists:departments,id',
            'ward_id'           => 'nullable|exists:wards,id',
            'room_id'           => 'nullable|exists:rooms,id',
            'bed_id'            => 'required|exists:beds,id',
            'admission_date'    => 'required|date',
        ]);

        Bed::where('id', $request->bed_id)->update(['is_occupied' => 1]);

        IpdAdmission::create([
            'ipd_no'            => $this->generateIpdNo(),
            'patient_id'        => $request->patient_id,
            'doctor_id'         => $request->doctor_id,
            'department_id'     => $request->department_id,
            'ward_id'           => $request->ward_id,
            'room_id'           => $request->room_id,
            'bed_id'            => $request->bed_id,
            'admission_date'    => $request->admission_date,
            'admission_reason'  => $request->admission_reason,
            'initial_diagnosis' => $request->initial_diagnosis,
        ]);

        return redirect()->route('ipd.index')->with('success', 'Patient admitted successfully.');
    }

    public function show(IpdAdmission $ipd)
    {
        $ipd->load('patient', 'doctor', 'ward', 'room', 'bed');
        return view('admin.ipd.show', compact('ipd'));
    }

    public function dischargeForm(IpdAdmission $ipd)
    {
        return view('admin.ipd.discharge', compact('ipd'));
    }

    public function discharge(Request $request, IpdAdmission $ipd)
    {
        $request->validate([
            'discharge_date'   => 'required|date',
            'final_diagnosis'  => 'required',
            'discharge_summary'=> 'required'
        ]);

        if ($ipd->bed_id) {
            Bed::where('id', $ipd->bed_id)->update(['is_occupied' => 0]);
        }

        $ipd->update([
            'discharge_date'    => $request->discharge_date,
            'final_diagnosis'   => $request->final_diagnosis,
            'discharge_summary' => $request->discharge_summary,
            'status'            => 0
        ]);

        return redirect()->route('ipd.show', $ipd->id)
            ->with('success', 'Patient discharged successfully.');
    }

    public function dischargePdf(IpdAdmission $ipd)
    {
        $pdf = \PDF::loadView('admin.ipd.discharge_pdf', compact('ipd'));
        return $pdf->download('discharge-summary-' . $ipd->ipd_no . '.pdf');
    }

    public function getRooms($ward_id)
    {
        return response()->json(Room::where('ward_id', $ward_id)->get());
    }

    public function getBeds($room_id)
    {
        return response()->json(
            Bed::where('room_id', $room_id)->where('is_occupied', 0)->get()
        );
    }
}
