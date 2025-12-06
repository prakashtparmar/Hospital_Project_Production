<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IssueMedicine;
use App\Models\IssueMedicineItem;
use App\Models\Patient;
use App\Models\User;
use App\Models\Medicine;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IssueMedicineController extends Controller
{
    public function index()
    {
        $issues = IssueMedicine::with(['patient', 'doctor', 'items'])
                    ->latest()
                    ->paginate(15);

        return view('admin.pharmacy.issue.index', compact('issues'));
    }

    public function create()
    {
        return view('admin.pharmacy.issue.create', [
            'patients'  => Patient::all(),
            'doctors'   => User::role('Doctor')->get(),
            'medicines' => Medicine::all()
        ]);
    }

    public function store(Request $request, StockService $stock)
    {
        $request->validate([
            'patient_id'    => 'required',
            'issue_date'    => 'required|date',
            'medicine_id.*' => 'required',
            'quantity.*'    => 'required|numeric|min:1',
            'rate.*'        => 'required|numeric|min:0'
        ]);

        $issue = IssueMedicine::create([
            'patient_id'   => $request->patient_id,
            'doctor_id'    => $request->doctor_id,
            'issue_date'   => $request->issue_date,
            'issue_no'     => 'ISS-' . strtoupper(Str::random(6)),
            'total_amount' => 0
        ]);

        $total = 0;

        foreach ($request->medicine_id as $i => $medicine_id) {

            $qty  = $request->quantity[$i];
            $rate = $request->rate[$i];
            $amt  = $qty * $rate;

            IssueMedicineItem::create([
                'issue_id'    => $issue->id,
                'medicine_id' => $medicine_id,
                'quantity'    => $qty,
                'rate'        => $rate,
                'amount'      => $amt
            ]);

            // ---------------------------------------------------
            // UPDATED: Batch-wise stock OUT using FEFO
            // No batch_no or expiry needed → service handles FEFO
            // ---------------------------------------------------
            $stock->adjustStock(
                $medicine_id,
                -$qty,                 // Always positive
                'ISSUE_TO_PATIENT',   // OUT type handled inside service
                $issue->id,
                null,                 // batch_no (FEFO auto)
                null                  // expiry_date
            );

            $total += $amt;
        }

        $issue->update(['total_amount' => $total]);

        return redirect()
            ->route('issue-medicines.index')
            ->with('success', 'Medicine issued successfully.');
    }

    public function show(IssueMedicine $issue_medicine)
    {
        return view('admin.pharmacy.issue.show', [
            'issue' => $issue_medicine->load(['items.medicine', 'patient', 'doctor'])
        ]);
    }
}
