<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\StockAdjustment;
use App\Services\StockService;
use Illuminate\Http\Request;

class StockAdjustmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:stock-adjustments.view')->only('index');
        $this->middleware('permission:stock-adjustments.create')->only(['create','store']);
    }

    public function index()
    {
        $adjustments = StockAdjustment::with('medicine')->latest()->paginate(15);
        return view('admin.pharmacy.adjustments.index', compact('adjustments'));
    }

    public function create()
    {
        return view('admin.pharmacy.adjustments.create', [
            'medicines' => Medicine::all()
        ]);
    }

    public function store(Request $request, StockService $stock)
    {
        $request->validate([
            'medicine_id'     => 'required|exists:medicines,id',
            'adjust_quantity' => 'required|integer',
        ]);

        StockAdjustment::create([
            'medicine_id'     => $request->medicine_id,
            'adjust_quantity' => $request->adjust_quantity,
            'reason'          => $request->reason, // ✅ FIXED
        ]);

        $stock->adjustStock(
            $request->medicine_id,
            $request->adjust_quantity,
            'ADJUSTMENT'
        );

        return redirect()
            ->route('stock-adjustments.index')
            ->with('success','Stock adjusted successfully.');
    }
}
