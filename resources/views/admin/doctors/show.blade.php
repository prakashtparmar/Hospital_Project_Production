@extends('layouts.app')

@section('content')

<div class="page-header">
    <h4 class="page-title">Doctor Details</h4>
</div>

<div class="card p-3">

    <h4>{{ $doctor->user->name }}</h4>
    <p>Email: {{ $doctor->user->email }}</p>

    <table class="table table-bordered mt-3">
        <tr><th>Department</th><td>{{ $doctor->department->name ?? 'N/A' }}</td></tr>
        <tr><th>Specialization</th><td>{{ $doctor->specialization }}</td></tr>
        <tr><th>Qualification</th><td>{{ $doctor->qualification }}</td></tr>
        <tr><th>Reg No</th><td>{{ $doctor->registration_no }}</td></tr>
        <tr><th>Consultation Fee</th><td>{{ number_format($doctor->consultation_fee, 2) }}</td></tr>
        <tr><th>Biography</th><td>{{ $doctor->biography }}</td></tr>
        <tr><th>Created</th><td>{{ $doctor->created_at->format('d M Y') }}</td></tr>
    </table>

    <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Back</a>

</div>

@endsection
