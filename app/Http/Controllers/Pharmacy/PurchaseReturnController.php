<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Models\Supplier;
use App\Services\StockService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        $returns = PurchaseReturn::latest()->paginate(20);
        return view('admin.pharmacy.returns.index', compact('returns'));
    }

    public function create()
    {
        return view('admin.pharmacy.returns.create', [
            'purchases' => Purchase::all()
        ]);
    }

    public function returnItems(Purchase $purchase)
    {
        return view('admin.pharmacy.returns.return-items', compact('purchase'));
    }

    public function store(Request $req)
    {
        $purchase = Purchase::find($req->purchase_id);

        $return = PurchaseReturn::create([
            'return_no' => 'RET-' . strtoupper(uniqid()),
            'purchase_id' => $purchase->id,
            'supplier_id' => $purchase->supplier_id,
            'total_amount' => 0,
            'tax_amount' => 0,
            'grand_total' => 0
        ]);

        $total = $gstTotal = 0;

        foreach ($req->return_qty as $itemId => $qty) {

            if ($qty <= 0) continue;

            $item = $purchase->items()->find($itemId);

            PurchaseReturnItem::create([
                'return_id' => $return->id,
                'medicine_id' => $item->medicine_id,
                'batch_no' => $item->batch_no,
                'qty' => $qty,
                'rate' => $item->purchase_rate,
                'gst' => $item->tax_percent,
                'total' => ($qty * $item->purchase_rate)
            ]);

            StockService::stockOut($item->medicine_id, $qty, 'PURCHASE_RETURN', $return->id);

            $total += ($qty * $item->purchase_rate);
            $gstTotal += (($qty * $item->purchase_rate) * $item->tax_percent / 100);
        }

        $return->update([
            'total_amount' => $total,
            'tax_amount' => $gstTotal,
            'grand_total' => $total + $gstTotal
        ]);

        return redirect()->route('purchase-return.index')->with('success','Purchase Return Completed.');
    }

    public function show(PurchaseReturn $purchaseReturn)
    {
        $ret = $purchaseReturn;
        return view('admin.pharmacy.returns.show', compact('ret'));
    }

    public function invoice(PurchaseReturn $purchaseReturn)
    {
        $ret = $purchaseReturn;
        $pdf = Pdf::loadView('admin.pharmacy.returns.invoice', compact('ret'));
        return $pdf->stream('return-'.$ret->return_no.'.pdf');
    }
}
