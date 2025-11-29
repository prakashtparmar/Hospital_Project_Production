@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
        <li><a href="{{ route('doctor-schedule.index') }}">Doctor Schedule</a></li>
        <li class="active">Edit Schedule</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title"><i class="fa fa-edit"></i> Edit Doctor Schedule</h4>
</div>

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade in">
    <button class="close" data-dismiss="alert">×</button>
    <ul>
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="widget-box">
    <div class="widget-header">
        <h5 class="widget-title">Update Schedule</h5>
    </div>

    <div class="widget-body">
        <div class="widget-main">

            {{-- Check Permission --}}
            @can('doctor-schedule.edit')

            <form action="{{ route('doctor-schedule.update', $schedule->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Doctor --}}
                    <div class="col-md-6 mb-3">
                        <label><strong>Doctor</strong></label>
                        <select class="form-control" name="doctor_id" required>
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}" 
                                    {{ $doc->id == $schedule->doctor_id ? 'selected' : '' }}>
                                    {{ $doc->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Department --}}
                    <div class="col-md-6 mb-3">
                        <label><strong>Department</strong></label>
                        <select class="form-control" name="department_id">
                            <option value="">-- None --</option>
                            @foreach($departments as $d)
                                <option value="{{ $d->id }}" 
                                    {{ $d->id == $schedule->department_id ? 'selected' : '' }}>
                                    {{ $d->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Day --}}
                    <div class="col-md-4 mb-3">
                        <label><strong>Day</strong></label>
                        <select class="form-control" name="day" required>
                            @foreach($days as $day)
                                <option value="{{ $day }}" 
                                    {{ $schedule->day == $day ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Start Time --}}
                    <div class="col-md-4 mb-3">
                        <label><strong>Start Time</strong></label>
                        <input type="time" name="start_time" class="form-control"
                               value="{{ $schedule->start_time }}" required>
                    </div>

                    {{-- End Time --}}
                    <div class="col-md-4 mb-3">
                        <label><strong>End Time</strong></label>
                        <input type="time" name="end_time" class="form-control"
                               value="{{ $schedule->end_time }}" required>
                    </div>

                    {{-- Slot Duration --}}
                    <div class="col-md-4 mb-3">
                        <label><strong>Slot Duration (minutes)</strong></label>
                        <input type="number" name="slot_duration" class="form-control"
                               value="{{ $schedule->slot_duration }}" required>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4 mb-3">
                        <label><strong>Status</strong></label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $schedule->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $schedule->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="text-right mt-3">
                    <a href="{{ route('doctor-schedule.index') }}" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>

                    {{-- Save Button Allowed Only if Edit Permission --}}
                    @can('doctor-schedule.edit')
                    <button class="btn btn-primary">
                        <i class="fa fa-save"></i> Update Schedule
                    </button>
                    @endcan
                </div>

            </form>

            {{-- If user has no edit permission --}}
            @else
                <div class="alert alert-warning">
                    <i class="fa fa-lock"></i> 
                    You do not have permission to <strong>edit schedules</strong>.
                </div>

                @can('doctor-schedule.view')
                    <a href="{{ route('doctor-schedule.index') }}" class="btn btn-default">Back</a>
                @endcan
            @endcan

        </div>
    </div>
</div>

@endsection
