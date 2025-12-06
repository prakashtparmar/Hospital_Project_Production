<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientApiController extends Controller
{
    public function profile()
    {
        $patient = Patient::where('user_id', auth()->id())->first();
        return response()->json($patient);
    }

    public function updateProfile(Request $request)
    {
        $patient = Patient::where('user_id', auth()->id())->first();
        $patient->update($request->all());
        return response()->json(['message'=>'Profile updated']);
    }

    public function appointments()
    {
        $patient = Patient::where('user_id', auth()->id())->first();
        return response()->json($patient->appointments()->latest()->get());
    }

    public function labReports()
    {
        $patient = Patient::where('user_id', auth()->id())->first();
        return response()->json($patient->labResults()->latest()->get());
    }

    public function radiologyReports()
    {
        $patient = Patient::where('user_id', auth()->id())->first();
        return response()->json($patient->radiologyResults()->latest()->get());
    }

    public function invoices()
    {
        $patient = Patient::where('user_id', auth()->id())->first();
        return response()->json($patient->invoices()->latest()->get());
    }
}
