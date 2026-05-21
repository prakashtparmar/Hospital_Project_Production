<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Medicine;
use App\Models\Supplier;
use App\Models\PurchaseItem;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::latest()->paginate(20);
        return view('admin.pharmacy.purchases.index', compact('purchases'));
    }

    public function create()
    {
        return view('admin.pharmacy.purchases.create', [
            'suppliers' => Supplier::all(),
            'medicines' => Medicine::all()
        ]);
    }

    private function invoiceNo()
    {
        return 'INV-' . date('Y') . '-' . str_pad(Purchase::count() + 1, 5, '0', STR_PAD_LEFT);
    }

    public function store(Request $req)
    {
        $req->validate([
            'supplier_id' => 'required',
            'medicine_id' => 'required|array'
        ]);

        $purchase = Purchase::create([
            'grn_no' => 'GRN-' . strtoupper(Str::random(6)),
            'invoice_no' => $this->invoiceNo(),
            'supplier_id' => $req->supplier_id,
            'purchase_date' => $req->purchase_date ?: now(),
            'total_amount' => 0,
            'tax_amount' => 0,
            'grand_total' => 0,
        ]);

        $total = $taxTotal = 0;

        foreach ($req->medicine_id as $i => $medicine_id) {

            $qty = $req->qty[$i];
            $rate = $req->rate[$i];
            $gst = $req->tax_percent[$i];
            $batch = $req->batch_no[$i] ?? null;
            $expiry = $req->expiry_date[$i] ?? null;

            $amount = $qty * $rate;
            $gstAmt = $amount * $gst / 100;

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'medicine_id' => $medicine_id,
                'quantity' => $qty,
                'purchase_rate' => $rate,
                'tax_percent' => $gst,
                'tax_amount' => $gstAmt,
                'total_amount' => $amount,
                'batch_no' => $batch,
                'expiry_date' => $expiry
            ]);

            StockService::stockIn($medicine_id, $qty, 'PURCHASE', $purchase->id, $batch, $expiry);

            $total += $amount;
            $taxTotal += $gstAmt;
        }

        $purchase->update([
            'total_amount' => $total,
            'tax_amount' => $taxTotal,
            'grand_total' => $total + $taxTotal
        ]);

        return redirect()->route('purchases.index')->with('success','Purchase saved.');
    }

    public function show(Purchase $purchase)
    {
        return view('admin.pharmacy.purchases.show', compact('purchase'));
    }

    public function print(Purchase $purchase)
    {
        $pdf = Pdf::loadView('admin.pharmacy.purchases.invoice', compact('purchase'));
        return $pdf->stream('invoice-'.$purchase->invoice_no.'.pdf');
    }
}
