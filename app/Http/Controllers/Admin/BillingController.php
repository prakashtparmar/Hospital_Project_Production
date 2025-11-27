<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillingInvoice;
use App\Models\BillingItem;
use App\Models\BillingPayment;
use App\Models\Patient;
use App\Models\AccountingEntry; // Added use statement
use App\Models\AccountingEntryItem; // Added use statement
use App\Models\Account; // Added use statement
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        $invoices = BillingInvoice::with('patient')->latest()->paginate(20);
        return view('admin.billing.index', compact('invoices'));
    }

    public function create()
    {
        return view('admin.billing.create', [
            'patients' => Patient::all()
        ]);
    }

    public function store(Request $request)
    {
        $invoice = BillingInvoice::create([
            'patient_id' => $request->patient_id,
            'invoice_no' => 'INV-' . time(),
            'total' => 0,
            'discount' => 0,
            'net_amount' => 0,
            'paid_amount' => 0,
            'due_amount' => 0
        ]);

        return redirect()->route('billing.edit', $invoice->id);
    }

    public function edit(BillingInvoice $billing)
    {
        return view('admin.billing.edit', compact('billing'));
    }

    public function addItem(Request $request, BillingInvoice $billing)
    {
        $amount = $request->qty * $request->rate;

        BillingItem::create([
            'invoice_id' => $billing->id,
            'item_name' => $request->item_name,
            'qty' => $request->qty,
            'rate' => $request->rate,
            'amount' => $amount,
            'source_type' => $request->source_type,
            'source_id' => $request->source_id,
        ]);

        $this->recalculate($billing);

        return back()->with('success', 'Item added.');
    }

    public function applyDiscount(Request $request, BillingInvoice $billing)
    {
        $billing->update(['discount' => $request->discount]);
        $this->recalculate($billing);
        return back()->with('success', 'Discount updated.');
    }

    public function addPayment(Request $request, BillingInvoice $billing)
    {
        // Create the billing payment record
        BillingPayment::create([
            'invoice_id' => $billing->id,
            'amount' => $request->amount,
            'mode' => $request->mode,
            'note' => $request->note
        ]);

        // ACCOUNTING ENTRY (Added logic here)
        $entry = AccountingEntry::create([
            'entry_date' => date('Y-m-d'),
            'voucher_no' => 'BR-' . time(),
            'type' => 'Receipt',
            'reference_type' => 'Billing',
            'reference_id' => $billing->id
        ]);

        // DEBIT: Cash Account
        AccountingEntryItem::create([
            'entry_id' => $entry->id,
            'account_id' => Account::where('name','Cash')->first()->id,
            'debit' => $request->amount,
            'credit' => 0
        ]);

        // CREDIT: Income Account
        AccountingEntryItem::create([
            'entry_id' => $entry->id,
            'account_id' => Account::where('name','Hospital Revenue')->first()->id,
            'debit' => 0,
            'credit' => $request->amount
        ]);
        // END OF ACCOUNTING ENTRY

        $this->recalculate($billing);

        return back()->with('success', 'Payment received.');
    }

    private function recalculate(BillingInvoice $billing)
    {
        $total = $billing->items()->sum('amount');
        $discount = $billing->discount;
        $net = $total - $discount;
        $paid = $billing->payments()->sum('amount');
        $due = $net - $paid;

        $billing->update([
            'total' => $total,
            'net_amount' => $net,
            'paid_amount' => $paid,
            'due_amount' => $due
        ]);
    }

    public function show(BillingInvoice $billing)
    {
        return view('admin.billing.show', compact('billing'));
    }

    //BILLING INVOICE PDF

    public function pdf(BillingInvoice $billing)
    {
        $pdf = \PDF::loadView('admin.billing.pdf', compact('billing'));
        return $pdf->download('invoice-' . $billing->invoice_no . '.pdf');
    }

    //Generate PDF for Billing Invoice
    public function invoicePdf(BillingInvoice $invoice)
{
    $pdf = \PDF::loadView('pdf.invoice', compact('invoice'));
    return $pdf->download("invoice-{$invoice->invoice_no}.pdf");
}


}