<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountingEntryItem;

class TrialBalanceController extends Controller
{
    public function index()
    {
        $items = AccountingEntryItem::selectRaw('account_id, sum(debit) as debit_total, sum(credit) as credit_total')
            ->groupBy('account_id')
            ->with('account')
            ->get();

        return view('admin.accounts.trial.index', compact('items'));
    }
}
