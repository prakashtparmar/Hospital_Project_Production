<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\OpdVisit;
use Illuminate\Http\Request;

class DoctorApiController extends Controller
{
    public function appointmentsToday()
    {
        return Appointment::where('doctor_id', auth()->id())
            ->whereDate('appointment_date', now()->toDateString())
            ->get();
    }

    public function opdNotes(Request $request, OpdVisit $visit)
    {
        $visit->update([
            'doctor_notes' => $request->doctor_notes
        ]);

        return response()->json(['message'=>'Notes updated']);
    }

    public function patientHistory($patientId)
    {
        $opd = \App\Models\OpdVisit::where('patient_id',$patientId)->get();
        $ipd = \App\Models\IpdAdmission::where('patient_id',$patientId)->get();
        return response()->json(['opd'=>$opd,'ipd'=>$ipd]);
    }
}
