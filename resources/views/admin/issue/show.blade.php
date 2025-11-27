@extends('layouts.auth')

@section('content')

<div class="card">
    <div class="card-header"><h4>Issue Details</h4></div>

    <div class="card-body">

        <p><strong>Patient:</strong> {{ $issue->patient->full_name }}</p>
        <p><strong>Date:</strong> {{ $issue->issue_date }}</p>

        <table class="table table-bordered mt-3">
            <tr>
                <th>Medicine</th>
                <th>Qty</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>

            @foreach($issue->items as $it)
            <tr>
                <td>{{ $it->medicine->name }}</td>
                <td>{{ $it->quantity }}</td>
                <td>{{ $it->rate }}</td>
                <td>{{ $it->amount }}</td>
            </tr>
            @endforeach

        </table>

        <h5>Total: {{ $issue->total_amount }}</h5>

    </div>
</div>

@endsection
