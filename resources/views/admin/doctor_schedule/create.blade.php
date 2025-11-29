@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
        <li><a href="{{ route('doctor-schedule.index') }}">Doctor Schedule</a></li>
        <li class="active">Add Schedule</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title"><i class="fa fa-clock-o"></i> Add Doctor Schedule</h4>
</div>

<div class="widget-box">
    <div class="widget-header">
        <h5 class="widget-title">Schedule Form</h5>
    </div>

    <div class="widget-body">
        <div class="widget-main">

            {{-- Check Permission --}}
            @can('doctor-schedule.create')

            <form action="{{ route('doctor-schedule.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Doctor --}}
                    <div class="col-md-6 mb-3">
                        <label><strong>Doctor</strong></label>
                        <select class="form-control" name="doctor_id" required>
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Department --}}
                    <div class="col-md-6 mb-3">
                        <label><strong>Department</strong></label>
                        <select class="form-control" name="department_id">
                            <option value="">-- None --</option>
                            @foreach($departments as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Day --}}
                    <div class="col-md-4 mb-3">
                        <label><strong>Day</strong></label>
                        <select class="form-control" name="day" required>
                            @foreach($days as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Start Time --}}
                    <div class="col-md-4 mb-3">
                        <label><strong>Start Time</strong></label>
                        <input type="time" class="form-control" name="start_time" required>
                    </div>

                    {{-- End Time --}}
                    <div class="col-md-4 mb-3">
                        <label><strong>End Time</strong></label>
                        <input type="time" class="form-control" name="end_time" required>
                    </div>

                    {{-- Slot Duration --}}
                    <div class="col-md-4 mb-3">
                        <label><strong>Slot Duration (minutes)</strong></label>
                        <input type="number" class="form-control" name="slot_duration" value="15">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4 mb-3">
                        <label><strong>Status</strong></label>
                        <select name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="text-right">
                    <a href="{{ route('doctor-schedule.index') }}" class="btn btn-default">Back</a>
                    <button class="btn btn-success">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>

            </form>

            @else

            {{-- No Permission Message --}}
            <div class="alert alert-warning">
                <i class="fa fa-lock"></i> 
                You do not have permission to <strong>add doctor schedules</strong>.
            </div>

            <a href="{{ route('doctor-schedule.index') }}" class="btn btn-default">Back</a>

            @endcan

        </div>
    </div>
</div>

@endsection
