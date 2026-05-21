@extends('layouts.app')

@section('breadcrumbs')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li><i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="active">Purchase Records</li>
        </ul>
    </div>
@endsection

@section('content')

<div class="page-header">
    <h1>
        <i class="fa fa-shopping-cart"></i> Purchase Records

        @can('purchases.create')
            <a href="{{ route('purchases.create') }}" class="btn btn-primary btn-sm pull-right">
                <i class="fa fa-plus"></i> New Purchase
            </a>
        @endcan
    </h1>
</div>

<div class="row">
<div class="col-xs-12">

<div class="widget-box">
<div class="widget-header">
    <h4 class="widget-title">Purchase History</h4>
</div>

<div class="widget-body">
<div class="widget-main no-padding">

<table class="table table-striped table-bordered table-hover">
<thead>
<tr>
    <th>#</th>
    <th>GRN</th>
    <th>Invoice</th>
    <th>Invoice Date</th>
    <th>Supplier</th>
    <th>Challan</th>
    <th>Payment Type</th>
    <th>Purchase Date</th>
    <th>Subtotal</th>
    <th>Discount</th>
    <th>GST</th>
    <th>Grand Total</th>
    <th>Status</th>
    <th style="width:200px;">Actions</th>
</tr>
</thead>

<tbody>
@foreach ($purchases as $p)
<tr data-toggle="collapse" data-target="#items-{{ $p->id }}" class="clickable">
    <td>{{ $loop->iteration }}</td>
    <td><span class="badge badge-info">{{ $p->grn_no }}</span></td>
    <td>{{ $p->invoice_no }}</td>
    <td>{{ $p->invoice_date ? \Carbon\Carbon::parse($p->invoice_date)->format('d M Y') : '—' }}</td>
    <td>{{ $p->supplier->name ?? '—' }}</td>

    <td>
        {{ $p->challan_no ?? '—' }}<br>
        <small>{{ $p->challan_date ? \Carbon\Carbon::parse($p->challan_date)->format('d M Y') : '' }}</small>
    </td>

    <td>
        <span class="label label-info">{{ ucfirst($p->payment_type ?? 'credit') }}</span>
    </td>

    <td>{{ \Carbon\Carbon::parse($p->purchase_date)->format('d M Y') }}</td>

    <td>₹{{ number_format($p->total_amount, 2) }}</td>
    <td>₹{{ number_format($p->discount_amount, 2) }}</td>
    <td>₹{{ number_format($p->tax_amount, 2) }}</td>
    <td><span class="badge badge-success">₹{{ number_format($p->grand_total, 2) }}</span></td>

    <td>
        @if ($p->status == 'inapproval')
            <span class="label label-warning">In Approval</span>
        @elseif ($p->status == 'approved')
            <span class="label label-success">Approved</span>
        @elseif ($p->status == 'completed')
            <span class="label label-primary">Completed</span>
        @elseif ($p->status == 'cancelled')
            <span class="label label-danger">Cancelled</span>
        @else
            <span class="label label-default">{{ ucfirst($p->status) }}</span>
        @endif
    </td>

    <td>
        @can('purchases.view')
            <a href="{{ route('purchases.show', $p->id) }}" class="btn btn-xs btn-primary">
                <i class="fa fa-eye"></i>
            </a>
            <a href="{{ route('purchases.invoice', $p->id) }}" class="btn btn-xs btn-warning">
                <i class="fa fa-print"></i>
            </a>
            <a href="{{ route('purchases.invoice.pdf', $p->id) }}" class="btn btn-xs btn-success">
                <i class="fa fa-download"></i>
            </a>
        @endcan

        @can('purchases.edit')
            @if ($p->status != 'completed')
                <a href="{{ route('purchases.edit', $p->id) }}" class="btn btn-xs btn-info">
                    <i class="fa fa-pencil"></i>
                </a>
            @else
                <button class="btn btn-xs btn-default" disabled>
                    <i class="fa fa-lock"></i>
                </button>
            @endif
        @endcan

        @can('purchases.delete')
            <form action="{{ route('purchases.destroy', $p->id) }}"
                  method="POST" style="display:inline-block;"
                  onsubmit="return confirm('Delete this purchase?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-xs btn-danger">
                    <i class="fa fa-trash-o"></i>
                </button>
            </form>
        @endcan
    </td>
</tr>

{{-- ITEM DETAILS --}}
<tr class="collapse" id="items-{{ $p->id }}">
<td colspan="15">
<strong>Purchased Items:</strong>

<table class="table table-bordered table-sm">
<thead>
<tr>
    <th>#</th>
    <th>Medicine</th>
    <th>Batch</th>
    <th>Expiry</th>
    <th>Qty</th>
    <th>Rate</th>
    <th>Total</th>
</tr>
</thead>

<tbody>
@foreach ($p->items as $i)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $i->medicine->name ?? '' }}</td>
    <td>{{ $i->batch_no }}</td>
    <td>{{ $i->expiry_date ? \Carbon\Carbon::parse($i->expiry_date)->format('d M Y') : '—' }}</td>
    <td>{{ $i->quantity }}</td>
    <td>₹{{ number_format($i->rate, 2) }}</td>
    <td><strong>₹{{ number_format($i->amount, 2) }}</strong></td>
</tr>
@endforeach
</tbody>
</table>

@if ($p->remarks)
    <p><strong>Remarks:</strong> {{ $p->remarks }}</p>
@endif
</td>
</tr>

@endforeach
</tbody>
</table>

</div>
</div>
</div>

</div>
</div>

@endsection
