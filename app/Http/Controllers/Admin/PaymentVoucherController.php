<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountingEntry;
use App\Models\AccountingEntryItem;
use Illuminate\Http\Request;

class PaymentVoucherController extends Controller
{
    public function create()
    {
        return view('admin.accounts.payment.create', [
            'accounts' => Account::all()
        ]);
    }

    public function store(Request $request)
    {
        $voucher = AccountingEntry::create([
            'entry_date' => $request->entry_date,
            'voucher_no' => 'PV-' . time(),
            'type' => 'Payment'
        ]);

        // CREDIT: Cash/Bank
        AccountingEntryItem::create([
            'entry_id' => $voucher->id,
            'account_id' => $request->cash_bank_account,
            'debit' => 0,
            'credit' => $request->amount
        ]);

        // DEBIT: Expense Account
        AccountingEntryItem::create([
            'entry_id' => $voucher->id,
            'account_id' => $request->expense_account,
            'debit' => $request->amount,
            'credit' => 0
        ]);

        return back()->with('success','Payment voucher recorded.');
    }
}
