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

class IssueMedicineController extends Controller
{
    public function index()
    {
        $issues = IssueMedicine::with('patient')->latest()->paginate(15);
        return view('admin.pharmacy.issue.index', compact('issues'));
    }

    public function create()
    {
        return view('admin.pharmacy.issue.create', [
            'patients' => Patient::all(),
            'doctors' => User::role('Doctor')->get(),
            'medicines' => Medicine::all()
        ]);
    }

    public function store(Request $request, StockService $stock)
    {
        $request->validate([
            'patient_id' => 'required',
            'medicine_id.*' => 'required',
            'quantity.*' => 'required|min:1'
        ]);

        $issue = IssueMedicine::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'opd_id'     => $request->opd_id,
            'ipd_id'     => $request->ipd_id,
            'issue_date' => date('Y-m-d'),
            'total_amount' => 0
        ]);

        $total = 0;

        foreach ($request->medicine_id as $i => $medicine_id) {

            $qty  = $request->quantity[$i];
            $rate = Medicine::find($medicine_id)->mrp ?? 0;
            $amt  = $qty * $rate;

            IssueMedicineItem::create([
                'issue_id' => $issue->id,
                'medicine_id' => $medicine_id,
                'quantity' => $qty,
                'rate' => $rate,
                'amount' => $amt
            ]);

            // STOCK OUT
            $stock->adjustStock($medicine_id, -$qty, 'ISSUE_TO_PATIENT', $issue->id);

            $total += $amt;
        }

        $issue->update(['total_amount' => $total]);

        return redirect()->route('issue-medicines.index')
            ->with('success','Medicines issued successfully. Stock updated.');
    }

    public function show(IssueMedicine $issue_medicine)
    {
        return view('admin.pharmacy.issue.show', [
            'issue' => $issue_medicine
        ]);
    }
}
