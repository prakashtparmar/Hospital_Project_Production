<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\ConsultationDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use PDF;

class ConsultationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:consultations.view')
            ->only(['index','show','patientHistory']);

        $this->middleware('permission:consultations.create')
            ->only(['create','store']);

        $this->middleware('permission:consultations.edit')
            ->only(['edit','update']);

        $this->middleware('permission:consultations.delete')
            ->only(['deleteDocument','destroy']);
    }

    public function index()
    {
        $consultations = Consultation::with(['patient','doctor'])
            ->orderBy('created_at','desc')
            ->paginate(20);

        return view('admin.consultations.index', compact('consultations'));
    }

    public function create(Request $request)
    {
        $patients     = Patient::orderBy('first_name')->get();
        $doctors      = User::role('Doctor')->get();
        $appointment  = $request->appointment_id
                        ? Appointment::find($request->appointment_id)
                        : null;

        return view('admin.consultations.create', compact('patients','doctors','appointment'));
    }

    /* STORE */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id'  => 'required|exists:patients,id',
            'doctor_id'   => 'required|exists:users,id',

            'pulse'       => 'nullable|numeric',
            'temperature' => 'nullable|numeric',
            'resp_rate'   => 'nullable|numeric',
            'spo2'        => 'nullable|numeric',
            'weight'      => 'nullable|numeric',
            'height'      => 'nullable|numeric',

            'bp'          => 'nullable|string|max:20',
        ]);

        $autoStatus = 'completed';

        $consultation = Consultation::create([
            'patient_id'   => $request->patient_id,
            'doctor_id'    => $request->doctor_id,
            'appointment_id' => $request->appointment_id,
            'status'       => $autoStatus,

            'chief_complaint' => $request->chief_complaint,
            'history'         => $request->history,
            'examination'     => $request->examination,
            'provisional_diagnosis' => $request->provisional_diagnosis,
            'final_diagnosis' => $request->final_diagnosis,
            'plan'            => $request->plan,

            'bp'             => $request->bp,
            'pulse'          => $request->pulse,
            'temperature'    => $request->temperature,
            'resp_rate'      => $request->resp_rate,
            'spo2'           => $request->spo2,
            'weight'         => $request->weight,
            'height'         => $request->height,

            'started_at' => Carbon::now(),
            'ended_at'   => Carbon::now(),
        ]);

        /* SAVE PRESCRIPTIONS */
        if ($request->drug_name) {

            $prescription = Prescription::create([
                'consultation_id' => $consultation->id,
                'patient_id'       => $consultation->patient_id,
                'doctor_id'        => $consultation->doctor_id,
                'prescribed_on'    => now(),
                'notes'            => $request->prescription_notes,
            ]);

            foreach ($request->drug_name as $i => $drug) {
                if (!$drug) continue;

                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'drug_name'       => $request->drug_name[$i],
                    'strength'        => $request->strength[$i],
                    'dose'            => $request->dose[$i],
                    'route'           => $request->route[$i],
                    'frequency'       => $request->frequency[$i],
                    'duration'        => $request->duration[$i],
                    'instructions'    => $request->instructions[$i],
                ]);
            }
        }

        /* AUTO UPDATE APPOINTMENT STATUS */
        if ($consultation->appointment_id) {
            $appt = $consultation->appointment;
            if ($appt) {
                $appt->update(['status' => 'Completed']);
            }
        }

        return redirect()->route('consultations.show', $consultation->id)
            ->with('success', 'Consultation created & marked as completed.');
    }

    /* SHOW */
    public function show(Consultation $consultation)
    {
        $consultation->load([
            'patient','doctor','appointment',
            'prescriptions.items',
            'documents'
        ]);

        $history = Consultation::with(['doctor','prescriptions.items'])
            ->where('patient_id', $consultation->patient_id)
            ->orderBy('created_at','desc')
            ->get();

        return view('admin.consultations.show', compact('consultation','history'));
    }

    /* EDIT */
    public function edit(Consultation $consultation)
    {
        $patients = Patient::orderBy('first_name')->get();
        $doctors  = User::role('Doctor')->get();

        $consultation->load(['prescriptions.items','documents']);

        $history = Consultation::with('doctor')
            ->where('patient_id', $consultation->patient_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.consultations.edit', compact(
            'consultation','patients','doctors','history'
        ));
    }

    /* UPDATE */
    public function update(Request $request, Consultation $consultation)
    {
        $request->validate([
            'patient_id'  => 'required|exists:patients,id',
            'doctor_id'   => 'required|exists:users,id',

            'pulse'       => 'nullable|numeric',
            'temperature' => 'nullable|numeric',
            'resp_rate'   => 'nullable|numeric',
            'spo2'        => 'nullable|numeric',
            'weight'      => 'nullable|numeric',
            'height'      => 'nullable|numeric',

            'bp'          => 'nullable|string|max:20',
        ]);

        $autoStatus = 'completed';

        $consultation->update([
            'patient_id' => $request->patient_id,
            'doctor_id'  => $request->doctor_id,
            'status'     => $autoStatus,

            'chief_complaint'     => $request->chief_complaint,
            'history'             => $request->history,
            'examination'         => $request->examination,
            'provisional_diagnosis' => $request->provisional_diagnosis,
            'final_diagnosis'     => $request->final_diagnosis,
            'plan'                => $request->plan,

            'bp'          => $request->bp,
            'pulse'       => $request->pulse,
            'temperature' => $request->temperature,
            'resp_rate'   => $request->resp_rate,
            'spo2'        => $request->spo2,
            'weight'      => $request->weight,
            'height'      => $request->height,
        ]);

        /* DOCUMENT UPLOAD (UPDATE) */
        if ($request->hasFile('documents')) {

            foreach ($request->file('documents') as $file) {

                $fileName = time() . '-' . $file->getClientOriginalName();

                $filePath = $file->storeAs(
                    "consultations/{$consultation->id}",
                    $fileName,
                    'public'
                );

                $consultation->documents()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                    'file_type' => $file->extension(),
                    'file_size' => $file->getSize() / 1024,
                ]);
            }
        }

        /* SYNC APPOINTMENT STATUS */
        if ($consultation->appointment_id) {
            $appointment = $consultation->appointment;
            if ($appointment) {
                $appointment->update(['status' => 'Completed']);
            }
        }

        return redirect()->route('consultations.show', $consultation->id)
            ->with('success', 'Consultation updated & marked as completed.');
    }

    /* PATIENT HISTORY */
    public function patientHistory(Patient $patient)
    {
        $history = Consultation::with('doctor')
            ->where('patient_id', $patient->id)
            ->orderBy('created_at','desc')
            ->get();

        return view('admin.consultations.partials.history', compact('patient','history'));
    }

    /* PDF */
    public function patientHistoryPdf(Patient $patient)
    {
        $history = Consultation::with(['doctor','prescriptions.items'])
            ->where('patient_id', $patient->id)
            ->get();

        $pdf = PDF::loadView('admin.consultations.pdf.history', [
            'patient' => $patient,
            'history' => $history
        ]);

        return $pdf->download("patient-history-{$patient->id}.pdf");
    }

    /* DELETE SINGLE DOCUMENT */
    public function deleteDocument($id)
    {
        $doc = ConsultationDocument::findOrFail($id);

        if (Storage::disk('public')->exists($doc->file_path)) {
            Storage::disk('public')->delete($doc->file_path);
        }

        $doc->delete();

        return back()->with('success', 'Document removed successfully.');
    }

    /* DELETE CONSULTATION */
    public function destroy(Consultation $consultation)
    {
        // 1. Delete documents
        foreach ($consultation->documents as $doc) {
            if (Storage::disk('public')->exists($doc->file_path)) {
                Storage::disk('public')->delete($doc->file_path);
            }
            $doc->delete();
        }

        // 2. Delete prescriptions & items
        foreach ($consultation->prescriptions as $prescription) {
            $prescription->items()->delete();
            $prescription->delete();
        }

        // 3. Delete consultation
        $consultation->delete();

        return redirect()->route('consultations.index')
            ->with('success', 'Consultation deleted successfully.');
    }
}
