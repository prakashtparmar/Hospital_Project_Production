@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h3 class="mb-3">Issued Medicine Details</h3>

    {{-- ISSUE MAIN INFO --}}
    <div class="card mb-4">
        <div class="card-body">

            <p><strong>Issue No:</strong> {{ $issue->issue_no }}</p>

            <p><strong>Issue Date:</strong> 
                {{ date('d-m-Y', strtotime($issue->issue_date)) }}
            </p>

            <p><strong>Patient Name:</strong> 
                {{ $issue->patient->first_name ?? '' }} {{ $issue->patient->last_name ?? '' }}
            </p>

            <p><strong>Doctor:</strong> 
                {{ $issue->doctor->name ?? 'N/A' }}
            </p>

            <p><strong>OPD ID:</strong> {{ $issue->opd_id ?? 'N/A' }}</p>
            <p><strong>IPD ID:</strong> {{ $issue->ipd_id ?? 'N/A' }}</p>

            <p><strong>Total Amount:</strong> 
                ₹ {{ number_format($issue->total_amount,2) }}
            </p>

        </div>
    </div>

    <hr>

    {{-- ITEMS TABLE --}}
    <h4 class="mb-3">Issued Medicines</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Medicine Name</th>
                <th>Strength</th>
                <th>Qty</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
        </thead>

        <tbody>
        @foreach($issue->items as $i)
            <tr>
                <td>{{ $i->medicine->name }}</td>
                <td>{{ $i->medicine->strength ?? '-' }}</td>
                <td>{{ $i->quantity }}</td>
                <td>₹ {{ number_format($i->rate,2) }}</td>
                <td>₹ {{ number_format($i->amount,2) }}</td>
            </tr>
        @endforeach
        </tbody>

        <tfoot>
            <tr class="table-success">
                <th colspan="4" class="text-right">Total Amount</th>
                <th>₹ {{ number_format($issue->total_amount,2) }}</th>
            </tr>
        </tfoot>

    </table>

</div>

@endsection
