@extends('layouts.auth')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Stock Adjustments</h4>
        <a href="{{ route('stock-adjustments.create') }}" class="btn btn-primary btn-sm">Adjust Stock</a>
    </div>

    <div class="card-body">

        <table class="table table-bordered">
            <tr>
                <th>Medicine</th>
                <th>Adjust Qty</th>
                <th>Reason</th>
                <th>Date</th>
            </tr>

            @foreach($adjustments as $adj)
            <tr>
                <td>{{ $adj->medicine->name }}</td>
                <td>{{ $adj->adjust_quantity }}</td>
                <td>{{ $adj->reason }}</td>
                <td>{{ $adj->created_at }}</td>
            </tr>
            @endforeach
        </table>

        {{ $adjustments->links() }}

    </div>
</div>

@endsection
