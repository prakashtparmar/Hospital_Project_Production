<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountingEntryItem;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    public function index()
    {
        return view('admin.accounts.ledger.index', [
            'accounts' => Account::all()
        ]);
    }

    public function view(Request $request)
    {
        $entries = AccountingEntryItem::with('account','entry')
            ->where('account_id', $request->account_id)
            ->orderBy('created_at')
            ->get();

        return view('admin.accounts.ledger.view', [
            'entries' => $entries
        ]);
    }
}
