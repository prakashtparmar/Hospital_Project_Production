<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Medicine;
use App\Models\Supplier;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:purchases.view')->only(['index', 'show']);
        $this->middleware('permission:purchases.create')->only(['create', 'store']);
        $this->middleware('permission:purchases.edit')->only(['edit', 'update']);
        $this->middleware('permission:purchases.delete')->only(['destroy']);
    }

    public function index()
    {
        $purchases = Purchase::with(['supplier', 'items.medicine'])
            ->latest()
            ->paginate(15);

        return view('admin.pharmacy.purchases.index', compact('purchases'));
    }

    public function show(Purchase $purchase)
{
    $purchase->load(['supplier', 'items.medicine']);

    return view('admin.pharmacy.purchases.show', compact('purchase'));
}


    public function create()
    {
        return view('admin.pharmacy.purchases.create', [
            'suppliers' => Supplier::all(),
            'medicines' => Medicine::all()
        ]);
    }

    public function store(Request $request, StockService $stock)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'purchase_date' => 'required|date',
            'medicine_id.*' => 'required|integer',
            'qty.*' => 'required|integer|min:1',
            'rate.*' => 'required|numeric|min:0',
        ]);

        // AUTO INCREMENT INVOICE NUMBER
        $lastInvoice = Purchase::orderBy('id', 'desc')->value('invoice_no');
        $nextInvoiceNumber = 1001;
        if ($lastInvoice && preg_match('/INV-(\d+)/', $lastInvoice, $m)) {
            $nextInvoiceNumber = intval($m[1]) + 1;
        }
        $autoInvoice = 'INV-' . $nextInvoiceNumber;

        // AUTO INCREMENT GRN NUMBER
        $lastGRN = Purchase::orderBy('id', 'desc')->value('grn_no');
        $nextGRNNumber = 1001;
        if ($lastGRN && preg_match('/GRN-(\d+)/', $lastGRN, $m)) {
            $nextGRNNumber = intval($m[1]) + 1;
        }
        $autoGRN = 'GRN-' . $nextGRNNumber;

        $purchase = Purchase::create([
            'supplier_id' => $request->supplier_id,
            'invoice_no' => $request->invoice_no ?: $autoInvoice,
            'purchase_date' => $request->purchase_date,
            'grn_no' => $autoGRN,
            'status' => $request->status ?? 'inapproval',
        ]);

        // ✅ CALCULATE SUBTOTAL
        $subtotal = 0;

        foreach ($request->medicine_id as $index => $medicine_id) {
            $amount = $request->qty[$index] * $request->rate[$index];
            $subtotal += $amount;

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'medicine_id' => $medicine_id,
                'quantity' => $request->qty[$index],
                'rate' => $request->rate[$index],
                'amount' => $amount,
                'batch_no' => $request->batch_no[$index] ?? null,
                'expiry_date' => $request->expiry_date[$index] ?? null,
            ]);
        }

        // ✅ SAVE TOTALS
        $purchase->update([
            'total_amount' => $subtotal,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'grand_total' => $subtotal,
        ]);

        // STOCK INSERT ONLY if STATUS = COMPLETED
        if ($purchase->status === 'completed') {
            foreach ($purchase->items as $item) {
                $stock->adjustStock(
                    $item->medicine_id,
                    $item->quantity,
                    'PURCHASE',
                    $purchase->id,
                    $item->batch_no,
                    $item->expiry_date
                );
            }
        }

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase saved successfully.');
    }

    public function edit(Purchase $purchase)
    {
        $purchase->load(['items.medicine']);

        return view('admin.pharmacy.purchases.edit', [
            'purchase' => $purchase,
            'suppliers' => Supplier::all(),
            'medicines' => Medicine::all(),
        ]);
    }

    public function update(Request $request, Purchase $purchase, StockService $stock)
    {
        $oldStatus = $purchase->status;
        $wasCompleted = ($oldStatus === 'completed');

        $purchase->update([
            'supplier_id' => $request->supplier_id,
            'invoice_no' => $request->invoice_no,
            'purchase_date' => $request->purchase_date,
            'status' => $request->status,
        ]);

        $purchase->load('items');

        if ($wasCompleted) {
            foreach ($purchase->items as $old) {
                $stock->adjustStock(
                    $old->medicine_id,
                    -$old->quantity,
                    'PURCHASE_REVERSAL',
                    $purchase->id,
                    $old->batch_no,
                    $old->expiry_date
                );
            }
        }

        PurchaseItem::where('purchase_id', $purchase->id)->delete();

        // ✅ RECALCULATE TOTALS
        $subtotal = 0;

        foreach ($request->medicine_id as $index => $medicine_id) {
            $amount = $request->qty[$index] * $request->rate[$index];
            $subtotal += $amount;

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'medicine_id' => $medicine_id,
                'quantity' => $request->qty[$index],
                'rate' => $request->rate[$index],
                'amount' => $amount,
                'batch_no' => $request->batch_no[$index] ?? null,
                'expiry_date' => $request->expiry_date[$index] ?? null,
            ]);
        }

        // ✅ UPDATE TOTALS
        $purchase->update([
            'total_amount' => $subtotal,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'grand_total' => $subtotal,
        ]);

        if ($purchase->status === 'completed') {
            foreach ($purchase->items as $item) {
                $stock->adjustStock(
                    $item->medicine_id,
                    $item->quantity,
                    'PURCHASE',
                    $purchase->id,
                    $item->batch_no,
                    $item->expiry_date
                );
            }
        }

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase updated successfully.');
    }

    public function invoicePdf(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.medicine']);

        $pdf = Pdf::loadView('admin.pharmacy.purchases.invoice', [
            'purchase' => $purchase
        ])->setPaper('A4', 'portrait');

        return $pdf->download("purchase-invoice-{$purchase->id}.pdf");
    }

    public function invoice(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.medicine']);
        return view('admin.pharmacy.purchases.invoice', compact('purchase'));
    }

    public function destroy(Purchase $purchase)
    {
        if ($purchase->status === 'completed') {
            foreach ($purchase->items as $item) {
                app(\App\Services\StockService::class)->adjustStock(
                    $item->medicine_id,
                    -$item->quantity,
                    'PURCHASE_REVERSAL',
                    $purchase->id,
                    $item->batch_no,
                    $item->expiry_date
                );
            }
        }

        PurchaseItem::where('purchase_id', $purchase->id)->delete();
        $purchase->delete();

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase deleted successfully.');
    }
}
