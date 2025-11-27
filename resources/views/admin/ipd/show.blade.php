@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header"><h4>IPD Admission Details</h4></div>

    @if($ipd->status == 1)
    <a href="{{ route('ipd.discharge.form', $ipd->id) }}" class="btn btn-danger">
        Discharge Patient
    </a>
@endif

@if($ipd->discharge_date)
    <a href="{{ route('ipd.discharge.pdf', $ipd->id) }}" class="btn btn-primary mt-3">
        Download Discharge Summary
    </a>
@endif



    <div class="card-body">
        <p><strong>IPD No:</strong> {{ $ipd->ipd_no }}</p>
        <p><strong>Patient:</strong> {{ $ipd->patient->full_name }}</p>
        <p><strong>Doctor:</strong> {{ $ipd->doctor->name ?? '-' }}</p>
        <p><strong>Department:</strong> {{ $ipd->department->name ?? '-' }}</p>

        <p><strong>Ward:</strong> {{ $ipd->ward->name ?? '-' }}</p>
        <p><strong>Room:</strong> {{ $ipd->room->room_no ?? '-' }}</p>
        <p><strong>Bed:</strong> {{ $ipd->bed->bed_no ?? '-' }}</p>

        <p><strong>Admission Date:</strong> {{ $ipd->admission_date }}</p>
        <p><strong>Reason:</strong> {{ $ipd->admission_reason }}</p>
        <p><strong>Initial Diagnosis:</strong> {{ $ipd->initial_diagnosis }}</p>

        <a href="{{ route('ipd.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
