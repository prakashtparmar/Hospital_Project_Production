@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state">
    <ul class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="active">Stock Ledger</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">Medicine Stock Ledger</h4>
</div>

<div class="table-header">Stock Movement History</div>

<div class="table-responsive">
<table class="table table-bordered table-striped table-hover datatable">
    <thead>
        <tr>
            <th>Date</th>
            <th>Medicine</th>
            <th>Qty (+/-)</th>
            <th>Running Stock</th>
            <th>Type</th>
            <th>Reference</th>
            <th>Batch</th>
            <th>Expiry</th>
            <th>Remarks</th>
        </tr>
    </thead>

    <tbody>
        @foreach($ledger as $l)
        <tr>
            <td>{{ $l->created_at->format('d-m-Y H:i') }}</td>
            <td>{{ $l->medicine->name }}</td>
            <td class="{{ $l->quantity >= 0 ? 'text-success' : 'text-danger' }}">
                {{ $l->quantity }}
            </td>
            <td>{{ $l->running_stock }}</td>
            <td>{{ $l->type }}</td>
            <td>{{ $l->reference_id ?? '—' }}</td>
            <td>{{ $l->batch_no ?? '—' }}</td>
            <td>{{ $l->expiry_date ?? '—' }}</td>
            <td>{{ $l->remarks ?? '—' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $ledger->links() }}

</div>
@endsection
