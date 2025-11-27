<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountingEntry;
use App\Models\AccountingEntryItem;
use Illuminate\Http\Request;

class JournalEntryController extends Controller
{
    public function create()
    {
        return view('admin.accounts.journal.create', [
            'accounts' => Account::all()
        ]);
    }

    public function store(Request $request)
    {
        $entry = AccountingEntry::create([
            'entry_date' => $request->entry_date,
            'voucher_no' => 'JV-' . time(),
            'type' => 'Journal'
        ]);

        // Debit side
        AccountingEntryItem::create([
            'entry_id' => $entry->id,
            'account_id' => $request->debit_account,
            'debit' => $request->amount,
            'credit' => 0
        ]);

        // Credit side
        AccountingEntryItem::create([
            'entry_id' => $entry->id,
            'account_id' => $request->credit_account,
            'debit' => 0,
            'credit' => $request->amount
        ]);

        return back()->with('success','Journal entry recorded.');
    }
}
