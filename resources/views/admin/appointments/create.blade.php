@extends('layouts.auth')

@section('content')

<div class="card">
    <div class="card-header"><h4>Book Appointment</h4></div>

    <div class="card-body">
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Patient</label>
                <select name="patient_id" class="form-control" required>
                    @foreach($patients as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->patient_id }} - {{ $p->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Doctor</label>
                <select name="doctor_id" class="form-control" required>
                    @foreach($doctors as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Department</label>
                <select name="department_id" class="form-control">
                    @foreach($departments as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Appointment Date</label>
                <input type="date" name="appointment_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Reason</label>
                <textarea name="reason" class="form-control"></textarea>
            </div>

            <button class="btn btn-success">Book Appointment</button>

        </form>
    </div>
</div>

@endsection
