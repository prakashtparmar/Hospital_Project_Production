<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockLedger;
use App\Models\Medicine;
use Illuminate\Http\Request;

class StockLedgerController extends Controller
{
    public function index(Request $req)
    {
        $medicines = Medicine::all();
        $records = [];

        if ($req->medicine_id) {
            $query = StockLedger::where('medicine_id', $req->medicine_id);

            if ($req->from) {
                $query->whereDate('created_at', '>=', $req->from);
            }
            if ($req->to) {
                $query->whereDate('created_at', '<=', $req->to);
            }

            $records = $query->orderBy('id')->get();
        }

        return view('admin.pharmacy.ledger.index', compact('records','medicines'));
    }
}
