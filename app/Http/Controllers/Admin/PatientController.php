<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:patients.view')->only(['index', 'show']);
        $this->middleware('permission:patients.create')->only(['create', 'store']);
        $this->middleware('permission:patients.edit')->only(['edit', 'update']);
        $this->middleware('permission:patients.delete')->only(['destroy']);
    }

    private function generatePatientId()
    {
        $last = Patient::latest()->first();
        $number = $last ? intval(substr($last->patient_id, 3)) + 1 : 1;
        return "PAT" . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function index(Request $request)
    {
        $search = $request->search;

        $patients = Patient::where(function ($q) use ($search) {
            $q->where('first_name', 'LIKE', "%$search%")
                ->orWhere('middle_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('patient_id', 'LIKE', "%$search%");
        })
            ->latest()
            ->paginate(10);

        $departments = Department::where('status', 1)->get();

        return view('admin.patients.index', compact('patients', 'search', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'    => 'required',
            'gender'        => 'required',
            'department_id' => 'nullable|exists:departments,id',
            'photo_path'    => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'first_name', 'middle_name', 'last_name',
            'date_of_birth', 'age', 'gender',
            'phone', 'email', 'address',
            'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relation',
            'family_details', 'past_history',
            'department_id', 'status'
        ]);

        $data['patient_id'] = $this->generatePatientId();

        if ($request->hasFile('photo_path')) {
            $data['photo_path'] = $request->file('photo_path')->store('patients/photos', 'public');
        }

        $patient = Patient::create($data);

        /** Create QR path before update */
        $qrName = $patient->patient_id . '.svg';
        $qrPath = 'patients/qrcodes/' . $qrName;

        /** Generate QR */
        $renderer = new ImageRenderer(new RendererStyle(300), new SvgImageBackEnd());
        $writer = new Writer($renderer);
        $svgData = $writer->writeString(route('patients.show', $patient->id));

        Storage::disk('public')->put($qrPath, $svgData);

        /** SINGLE update call */
        $patient->update([
            'qr_code' => $qrPath
        ]);

        // Auto-return for appointments
        if ($request->from_appointment == 1) {
            return redirect()
                ->route('appointments.create', ['selected_patient' => $patient->id])
                ->with('success', 'Patient registered successfully.');
        }

        return redirect()->route('patients.index')
            ->with('success', 'Patient registered successfully.');
    }

    public function show(Patient $patient)
    {
        return view('admin.patients.show', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'first_name'    => 'required',
            'gender'        => 'required',
            'department_id' => 'nullable|exists:departments,id',
            'photo_path'    => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'first_name', 'middle_name', 'last_name',
            'date_of_birth', 'age', 'gender',
            'phone', 'email', 'address',
            'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relation',
            'family_details', 'past_history',
            'department_id', 'status'
        ]);

        if ($request->hasFile('photo_path')) {
            $data['photo_path'] = $request->file('photo_path')->store('patients/photos', 'public');
        }

        /** Generate QR (path) before update */
        $qrName = $patient->patient_id . '.svg';
        $qrPath = 'patients/qrcodes/' . $qrName;

        $renderer = new ImageRenderer(new RendererStyle(300), new SvgImageBackEnd());
        $writer = new Writer($renderer);
        $svgData = $writer->writeString(route('patients.show', $patient->id));

        Storage::disk('public')->put($qrPath, $svgData);

        /** Merge QR in SAME update call */
        $data['qr_code'] = $qrPath;

        /** ONLY ONE update = ONLY ONE activity log */
        $patient->update($data);

        return redirect()->route('patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return back()->with('success', 'Patient removed.');
    }
}
