@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header"><h4>OPD Visit Details</h4></div>

    <div class="card-body">

        <p><strong>OPD No:</strong> {{ $opd->opd_no }}</p>
        <p><strong>Patient:</strong> {{ $opd->patient->full_name }}</p>
        <p><strong>Doctor:</strong> {{ $opd->doctor->name ?? '-' }}</p>
        <p><strong>Department:</strong> {{ $opd->department->name ?? '-' }}</p>
        <p><strong>Visit Date:</strong> {{ $opd->visit_date }}</p>

        <hr>

        <p><strong>Symptoms:</strong><br>{{ $opd->symptoms }}</p>
        <p><strong>Diagnosis:</strong><br>{{ $opd->diagnosis }}</p>

        <hr>

        <h5>Vitals</h5>
        <p><strong>BP:</strong> {{ $opd->bp }}</p>
        <p><strong>Temperature:</strong> {{ $opd->temperature }}</p>
        <p><strong>Pulse:</strong> {{ $opd->pulse }}</p>
        <p><strong>Weight:</strong> {{ $opd->weight }}</p>

        <a href="{{ route('opd.index') }}" class="btn btn-secondary">Back</a>

    </div>
</div>
@endsection
