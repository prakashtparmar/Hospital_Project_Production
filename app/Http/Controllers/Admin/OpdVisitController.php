<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpdVisit;
use App\Models\Patient;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use Carbon\Carbon;

class OpdVisitController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:opd.view')->only(['index', 'show']);
        $this->middleware('permission:opd.create')->only(['create', 'store']);
        $this->middleware('permission:opd.edit')->only(['edit', 'update']);
        $this->middleware('permission:opd.delete')->only(['destroy']);
    }

    public function generateOpdNo()
    {
        $last = OpdVisit::withTrashed()->latest('id')->first();

        if ($last && preg_match('/OPD(\d+)/', $last->opd_no, $m)) {
            $next = intval($m[1]) + 1;
        } else {
            $next = 1;
        }

        return "OPD" . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function index(Request $request)
    {
        $search = $request->search;

        $visits = OpdVisit::with(['patient', 'doctor', 'department'])
            ->when($search, function ($q) use ($search) {

                // FIXED — wrapped inside grouping
                $q->where(function ($q2) use ($search) {
                    $q2->where('opd_no', 'LIKE', "%$search%")
                        ->orWhereHas('patient', function ($p) use ($search) {
                            $p->where('first_name', 'LIKE', "%$search%")
                                ->orWhere('last_name', 'LIKE', "%$search%")
                                ->orWhere('patient_id', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('doctor', function ($d) use ($search) {
                            $d->where('name', 'LIKE', "%$search%");
                        });
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.opd.index', compact('visits', 'search'));
    }

    public function create()
    {
        $patients = Patient::where('status', 1)->get();
        $departments = Department::where('status', 1)->get();

        // FIX — Normalize day names
        $today = Carbon::now()->format('l'); // Example: Monday

        $scheduledDoctors = DoctorSchedule::whereRaw('LOWER(day) = ?', strtolower($today))
            ->where('status', 1)
            ->pluck('doctor_id')
            ->toArray();

        // FIX — fallback so doctor list never becomes empty
        if (count($scheduledDoctors) === 0) {
            $scheduledDoctors = User::role('Doctor')->pluck('id')->toArray();
        }

        $doctors = User::whereIn('id', $scheduledDoctors)
            ->with(['doctorProfile', 'doctorProfile.department'])
            ->get();

        return view('admin.opd.create', compact('patients', 'departments', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'visit_date' => 'required|date',
        ]);

        OpdVisit::create([
            'opd_no' => $this->generateOpdNo(),
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'department_id' => $request->department_id,
            'visit_date' => $request->visit_date,
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'bp' => $request->bp,
            'temperature' => $request->temperature,
            'pulse' => $request->pulse,
            'weight' => $request->weight,
            'status' => $request->status
        ]);

        return redirect()->route('opd.index')->with('success', 'OPD visit created successfully.');
    }

    public function show(OpdVisit $opd)
    {
        return view('admin.opd.show', compact('opd'));
    }

    public function edit(OpdVisit $opd)
    {
        $patients = Patient::where('status', 1)->get();
        $departments = Department::where('status', 1)->get();
        $doctors = User::role('Doctor')->get();

        return view('admin.opd.edit', compact('opd', 'patients', 'departments', 'doctors'));
    }

    public function update(Request $request, OpdVisit $opd)
    {
        $request->validate([
            'patient_id' => 'required',
            'visit_date' => 'required|date',
        ]);

        $opd->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'department_id' => $request->department_id,
            'visit_date' => $request->visit_date,
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'bp' => $request->bp,
            'temperature' => $request->temperature,
            'pulse' => $request->pulse,
            'weight' => $request->weight,
            'status' => $request->status
        ]);

        return redirect()->route('opd.index')->with('success', 'OPD visit updated successfully.');
    }

    public function destroy(OpdVisit $opd)
    {
        $opd->delete();
        return back()->with('success', 'OPD visit deleted.');
    }
}
