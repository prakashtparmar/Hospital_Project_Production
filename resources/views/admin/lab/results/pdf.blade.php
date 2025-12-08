<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lab Report #{{ $lab_request->id }}</title>

    <style>
        body {
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 4px;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
        }

        .results-table th,
        .results-table td {
            border: 1px solid #000;
            padding: 6px;
        }

        .results-table th {
            background: #f2f2f2;
            text-align: left;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
        }
    </style>
</head>

<body>

{{-- HEADER --}}
<div class="header">
    <h2>{{ config('app.name') }}</h2>
    <p><strong>Laboratory Report</strong></p>
</div>

{{-- PATIENT INFO --}}
<table class="info-table">
    <tr>
        <td><strong>Patient Name:</strong></td>
        <td>
            {{ $lab_request->patient->first_name ?? '' }}
            {{ $lab_request->patient->last_name ?? '' }}
        </td>

        <td><strong>Patient ID:</strong></td>
        <td>{{ $lab_request->patient->patient_id ?? '—' }}</td>
    </tr>

    <tr>
        <td><strong>Request ID:</strong></td>
        <td>#{{ $lab_request->id }}</td>

        <td><strong>Date:</strong></td>
        <td>{{ $lab_request->created_at->format('d M, Y') }}</td>
    </tr>

    <tr>
        <td><strong>Doctor:</strong></td>
        <td colspan="3">
            {{ $lab_request->doctor->name ?? '—' }}
        </td>
    </tr>
</table>

{{-- RESULTS --}}
<table class="results-table">
    <thead>
        <tr>
            <th width="25%">Test</th>
            <th width="30%">Parameter</th>
            <th width="20%">Result</th>
            <th width="25%">Reference Range</th>
        </tr>
    </thead>

    <tbody>
    @foreach($lab_request->items as $item)
        @foreach($item->test->parameters as $p)

            @php
                $result = $lab_request->results
                    ? $lab_request->results->firstWhere('parameter_id', $p->id)
                    : null;
            @endphp

            <tr>
                <td>{{ $item->test->name }}</td>

                <td>
                    {{ $p->name }}
                    @if($p->unit)
                        ({{ $p->unit }})
                    @endif
                </td>

                <td>
                    {{ $result->value ?? '—' }}
                </td>

                <td>
                    {{ $p->reference_range ?? '—' }}
                </td>
            </tr>

        @endforeach
    @endforeach
    </tbody>
</table>

{{-- FOOTER --}}
<div class="footer">
    <p>
        Generated on {{ now()->format('d M, Y h:i A') }}
        <br>
        <strong>Status:</strong> {{ $lab_request->status }}
    </p>
</div>

</body>
</html>
