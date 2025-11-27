<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Medicine;
use App\Models\Supplier;
use App\Services\StockService;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier')->latest()->paginate(15);
        return view('admin.pharmacy.purchases.index', compact('purchases'));
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
            'supplier_id' => 'required',
            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'medicine_id.*' => 'required',
            'quantity.*' => 'required|integer|min:1',
            'rate.*' => 'required|numeric|min:0'
        ]);

        $purchase = Purchase::create([
            'supplier_id' => $request->supplier_id,
            'invoice_no' => $request->invoice_no,
            'invoice_date' => $request->invoice_date,
            'total_amount' => 0
        ]);

        $total = 0;

        foreach ($request->medicine_id as $index => $medicine_id) {
            $qty   = $request->quantity[$index];
            $rate  = $request->rate[$index];
            $amt   = $qty * $rate;

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'medicine_id' => $medicine_id,
                'quantity'    => $qty,
                'rate'        => $rate,
                'amount'      => $amt
            ]);

            // STOCK IN
            $stock->adjustStock($medicine_id, $qty, 'PURCHASE', $purchase->id);

            $total += $amt;
        }

        $purchase->update(['total_amount' => $total]);

        return redirect()->route('purchases.index')->with('success','Purchase recorded and stock updated.');
    }

    public function show(Purchase $purchase)
    {
        return view('admin.pharmacy.purchases.show', compact('purchase'));
    }
}
