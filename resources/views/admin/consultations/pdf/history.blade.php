<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Patient History PDF</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2, h3 { margin-bottom: 5px; }
        .section { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table th, table td { border: 1px solid #666; padding: 5px; }
        .title-bar {
            background: #ddd;
            padding: 8px 10px;
            margin-top: 25px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<h2>Patient Full Medical History</h2>

<hr>

<h3>Patient Info</h3>
<p>
    <strong>ID:</strong> {{ $patient->patient_id }} <br>
    <strong>Name:</strong> {{ $patient->first_name }} {{ $patient->last_name }} <br>
    <strong>Gender:</strong> {{ $patient->gender }} <br>
    <strong>DOB:</strong> 
        {{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d-M-Y') : '—' }} 
        <br>
</p>

<hr>

@foreach($history as $c)

<div class="title-bar">
    Consultation —  
    {{ \Carbon\Carbon::parse($c->created_at)->format('d-M-Y h:i A') }}  
    (Dr. {{ $c->doctor->name }})
</div>

<div class="section">

    <strong>Chief Complaint:</strong>
    <p>{{ $c->chief_complaint ?? '—' }}</p>

    <strong>History:</strong>
    <p>{{ $c->history ?? '—' }}</p>

    <strong>Examination:</strong>
    <p>{{ $c->examination ?? '—' }}</p>

    <strong>Diagnosis:</strong>
    <p>{{ $c->final_diagnosis ?? $c->provisional_diagnosis ?? '—' }}</p>

    <strong>Treatment Plan:</strong>
    <p>{{ $c->plan ?? '—' }}</p>

    <strong>Consultation Started:</strong><br>
    {{ $c->started_at ? \Carbon\Carbon::parse($c->started_at)->format('d-M-Y h:i A') : '—' }}
    <br><br>

    <strong>Consultation Ended:</strong><br>
    {{ $c->ended_at ? \Carbon\Carbon::parse($c->ended_at)->format('d-M-Y h:i A') : '—' }}

</div>

@if($c->prescriptions->count())

    <h4>Prescriptions</h4>

    @foreach($c->prescriptions as $p)

        <p>
            <strong>Date:</strong>  
            {{ $p->prescribed_on ? \Carbon\Carbon::parse($p->prescribed_on)->format('d-M-Y h:i A') : '—' }}
            <br>

            <strong>Notes:</strong> {{ $p->notes ?? '—' }}
        </p>

        <table>
            <thead>
            <tr>
                <th>Drug</th>
                <th>Strength</th>
                <th>Dose</th>
                <th>Route</th>
                <th>Frequency</th>
                <th>Duration</th>
            </tr>
            </thead>

            <tbody>
            @foreach($p->items as $i)
                <tr>
                    <td>{{ $i->drug_name }}</td>
                    <td>{{ $i->strength }}</td>
                    <td>{{ $i->dose }}</td>
                    <td>{{ $i->route }}</td>
                    <td>{{ $i->frequency }}</td>
                    <td>{{ $i->duration }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endforeach

@endif

@endforeach

</body>
</html>
