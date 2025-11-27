@extends('layouts.auth')

@section('content')

<div class="card">
    <div class="card-header"><h4>Add Doctor Schedule</h4></div>

    <div class="card-body">
        <form action="{{ route('doctor-schedule.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Doctor</label>
                <select class="form-control" name="doctor_id">
                    @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Department</label>
                <select class="form-control" name="department_id">
                    @foreach($departments as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Day</label>
                <select class="form-control" name="day">
                    @foreach($days as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Start Time</label>
                <input type="time" class="form-control" name="start_time">
            </div>

            <div class="mb-3">
                <label>End Time</label>
                <input type="time" class="form-control" name="end_time">
            </div>

            <div class="mb-3">
                <label>Slot Duration (minutes)</label>
                <input type="number" class="form-control" name="slot_duration" value="15">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <button class="btn btn-success">Save</button>

        </form>
    </div>
</div>

@endsection
