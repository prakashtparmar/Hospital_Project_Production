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

    private function generateOpdNo()
    {
        // include soft deleted OPD visits to avoid duplicate OPD0001
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

        $visits = OpdVisit::with(['patient','doctor','department'])
            ->when($search, function ($q) use ($search) {
                $q->where('opd_no', 'LIKE', "%$search%")
                  ->orWhereHas('patient', function ($p) use ($search) {
                      $p->where('first_name', 'LIKE', "%$search%")
                        ->orWhere('last_name', 'LIKE', "%$search%")
                        ->orWhere('patient_id', 'LIKE', "%$search%");
                  })
                  ->orWhereHas('doctor', function ($d) use ($search) {
                      $d->where('name', 'LIKE', "%$search%");
                  });
            })
            ->latest()
            ->paginate(10);

        return view('admin.opd.index', compact('visits', 'search'));
    }

    // public function create()
    // {
    //     $patients = Patient::where('status', 1)->get();
    //     $departments = Department::where('status', 1)->get();
    //     $doctors = User::role('Doctor')->get();

    //     return view('admin.opd.create', compact('patients', 'departments', 'doctors'));
    // }

    public function create()
{
    $patients = Patient::where('status', 1)->get();
    $departments = Department::where('status', 1)->get();

    $today = Carbon::now()->format('l'); // Monday – Sunday

    // Fetch doctors having a schedule today
    $scheduledDoctors = DoctorSchedule::where('day', $today)
                        ->where('status', 1)
                        ->pluck('doctor_id');

    // Get matching users WITH doctor profiles
    $doctors = User::whereIn('id', $scheduledDoctors)
                   ->with('doctorProfile')
                   ->get();

    return view('admin.opd.create', compact('patients', 'departments', 'doctors'));
}


    public function store(Request $request)
    {
        $request->validate([
            'patient_id'    => 'required',
            'visit_date'    => 'required|date',
        ]);

        OpdVisit::create([
            'opd_no'        => $this->generateOpdNo(),
            'patient_id'    => $request->patient_id,
            'doctor_id'     => $request->doctor_id,
            'department_id' => $request->department_id,
            'visit_date'    => $request->visit_date,
            'symptoms'      => $request->symptoms,
            'diagnosis'     => $request->diagnosis,
            'bp'            => $request->bp,
            'temperature'   => $request->temperature,
            'pulse'         => $request->pulse,
            'weight'        => $request->weight,
            'status'        => $request->status
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

        $opd->update($request->all());

        return redirect()->route('opd.index')->with('success', 'OPD visit updated successfully.');
    }

    public function destroy(OpdVisit $opd)
    {
        $opd->delete();
        return back()->with('success', 'OPD visit deleted.');
    }
}
