@extends('layouts.auth')

@section('content')

<div class="card">
    <div class="card-header"><h4>Appointment Details</h4></div>

    <div class="card-body">

        <p><strong>Patient:</strong> {{ $appointment->patient->full_name }}</p>
        <p><strong>Doctor:</strong> {{ $appointment->doctor->name }}</p>
        <p><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
        <p><strong>Time:</strong> {{ $appointment->appointment_time }}</p>
        <p><strong>Token:</strong> {{ $appointment->token_no }}</p>
        <p><strong>Status:</strong> {{ $appointment->status }}</p>
        <p><strong>Reason:</strong> {{ $appointment->reason }}</p>

        <a href="{{ route('appointments.index') }}" class="btn btn-secondary mt-3">Back</a>

    </div>
</div>

@endsection
