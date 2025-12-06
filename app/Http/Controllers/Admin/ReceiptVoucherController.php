<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountingEntry;
use App\Models\AccountingEntryItem;
use Illuminate\Http\Request;

class ReceiptVoucherController extends Controller
{
    public function create()
    {
        return view('admin.accounts.receipt.create', [
            'accounts' => Account::all()
        ]);
    }

    public function store(Request $request)
    {
        $voucher = AccountingEntry::create([
            'entry_date' => $request->entry_date,
            'voucher_no' => 'RV-' . time(),
            'type' => 'Receipt'
        ]);

        // DEBIT: Cash/Bank
        AccountingEntryItem::create([
            'entry_id' => $voucher->id,
            'account_id' => $request->cash_bank_account,
            'debit' => $request->amount,
            'credit' => 0
        ]);

        // CREDIT: Income Account
        AccountingEntryItem::create([
            'entry_id' => $voucher->id,
            'account_id' => $request->income_account,
            'debit' => 0,
            'credit' => $request->amount
        ]);

        return back()->with('success','Receipt voucher recorded.');
    }
}
