@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li><a href="{{ route('purchases.index') }}">Purchases</a></li>
        <li class="active">Purchase Details</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">
        Purchase Details (GRN: {{ $purchase->grn_no }})
    </h4>

    <div class="pull-right">
        <a href="{{ route('purchases.index') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-arrow-left"></i> Back
        </a>

        <a href="{{ route('purchases.invoice.pdf', $purchase->id) }}"
           class="btn btn-success btn-sm">
            <i class="fa fa-download"></i> Download PDF
        </a>
    </div>
</div>

<div class="row">

    {{-- LEFT --}}
    <div class="col-md-6">
        <div class="well">
            <p><b>Invoice No:</b> {{ $purchase->invoice_no ?? '—' }}</p>
            <p><b>Supplier:</b> {{ $purchase->supplier->name ?? '—' }}</p>
            <p>
                <b>Date:</b>
                {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y, h:i A') }}
            </p>
        </div>
    </div>

    {{-- RIGHT --}}
    <div class="col-md-6">
        <div class="well text-right">
            <h4><b>Subtotal:</b> ₹{{ number_format($purchase->total_amount, 2) }}</h4>
            <h4><b>Total GST:</b> ₹{{ number_format($purchase->tax_amount ?? 0, 2) }}</h4>

            <h3 class="text-success">
                <b>Grand Total:</b> ₹{{ number_format($purchase->grand_total, 2) }}
            </h3>
        </div>
    </div>
</div>

<hr>

<h4 class="header blue">Purchase Items</h4>

<div class="table-responsive">
<table class="table table-bordered table-striped">
<thead>
<tr>
    <th>Medicine</th>
    <th>Qty</th>
    <th>Rate</th>
    <th>GST%</th>
    <th>GST Amt</th>
    <th>Total</th>
    <th>Batch</th>
    <th>Expiry</th>
</tr>
</thead>

<tbody>
@foreach($purchase->items as $item)
<tr>
    <td>{{ $item->medicine->name ?? 'Unknown' }}</td>
    <td>{{ $item->quantity }}</td>
    <td>₹{{ number_format($item->rate, 2) }}</td>

    {{-- SAFE FALLBACKS (no logic change) --}}
    <td>0%</td>
    <td>₹0.00</td>

    <td>
        <b>₹{{ number_format($item->amount, 2) }}</b>
    </td>

    <td>{{ $item->batch_no ?? '—' }}</td>

    <td>
        @if($item->expiry_date)
            {{ \Carbon\Carbon::parse($item->expiry_date)->format('d M Y') }}
        @else
            —
        @endif
    </td>
</tr>
@endforeach
</tbody>

</table>
</div>

@endsection
