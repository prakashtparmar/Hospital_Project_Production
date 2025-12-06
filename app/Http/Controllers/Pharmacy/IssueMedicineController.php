<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IssueMedicine;
use App\Models\IssueMedicineItem;
use App\Models\Medicine;
use App\Services\StockService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class IssueMedicineController extends Controller
{
    public function index()
    {
        $issues = IssueMedicine::latest()->paginate(20);
        return view('admin.pharmacy.issue.index', compact('issues'));
    }

    public function create()
    {
        return view('admin.pharmacy.issue.create', [
            'patients' => \App\Models\Patient::all(),
            'medicines' => Medicine::all()
        ]);
    }

    public function store(Request $req)
{
    try {

        $bill = IssueMedicine::create([
            'bill_no' => 'BILL-' . strtoupper(Str::random(6)),
            'patient_id' => $req->patient_id,
            'total_amount' => $req->total_amount,
            'tax_amount' => $req->tax_amount,
            'discount' => $req->discount,
            'grand_total' => $req->grand_total
        ]);

        foreach ($req->medicine_id as $i => $medId) {

            // Check if quantity > stock BEFORE saving items
            $medicine = Medicine::find($medId);
            if ($req->qty[$i] > $medicine->current_stock) {
                return back()
                    ->withInput()
                    ->withErrors([
                        "You cannot issue {$req->qty[$i]} units of {$medicine->name}.
                         Only {$medicine->current_stock} available."
                    ]);
            }

            IssueMedicineItem::create([
                'issue_id' => $bill->id,
                'medicine_id' => $medId,
                'batch_no' => $req->batch_no[$i] ?? null,
                'expiry' => $req->expiry[$i] ?? null,
                'qty' => $req->qty[$i],
                'mrp' => $req->mrp[$i],
                'gst' => $req->tax_percent[$i],
                'total' => $req->mrp[$i] * $req->qty[$i]
            ]);

            // ✔ FIXED — call adjustStock so try/catch works
            app(StockService::class)->adjustStock(
                $medId,
                -$req->qty[$i],
                'ISSUE',
                $bill->id
            );
        }

        return redirect()->route('issue-medicines.index')
            ->with('success','Sale Completed.');

    } catch (\Exception $ex) {

        return back()
            ->withInput()
            ->withErrors([$ex->getMessage()]);
    }
}


    public function show(IssueMedicine $issueMedicine)
    {
        $issue = $issueMedicine;
        return view('admin.pharmacy.issue.show', compact('issue'));
    }

    public function invoice(IssueMedicine $issueMedicine)
    {
        $issue = $issueMedicine;
        $pdf = Pdf::loadView('admin.pharmacy.issue.invoice', compact('issue'));
        return $pdf->stream('bill-'.$issue->bill_no.'.pdf');
    }
}
