@extends('layouts.app')

@section('title', 'Create Appointment')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
        <li><a href="{{ route('appointments.index') }}">Appointments</a></li>
        <li class="active">Create Appointment</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h1>
        Appointment Management
        <small><i class="ace-icon fa fa-angle-double-right"></i> Create Appointment</small>

        <a href="{{ route('appointments.index') }}" class="btn btn-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </h1>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong>
    <ul>
        @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('appointments.store') }}" method="POST">
    @csrf

    <div class="row">

        {{-- LEFT COLUMN --}}
        <div class="col-md-6">
            <div class="widget-box">
                <div class="widget-header">
                    <h5 class="widget-title">Appointment Information</h5>
                </div>

                <div class="widget-body">
                    <div class="widget-main">

                        {{-- Patient --}}
                        <div class="form-group">
                            <label><strong>Patient *</strong></label>
                            <select name="patient_id" class="form-control select2">
                                <option value="">Select Patient...</option>
                                @foreach ($patients as $p)
                                    <option value="{{ $p->id }}" {{ old('patient_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->patient_id }} - {{ $p->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Doctor Specialty --}}
                        <div class="form-group">
                            <label><strong>Specialty *</strong></label>
                            <select id="specialtySelect" class="form-control select2">
                                <option value="">Select Specialty...</option>

                                @foreach (
                                    $doctors
                                        ->map(fn($d) => optional($d->doctorProfile)->specialization)
                                        ->filter()
                                        ->unique()
                                    as $sp
                                )
                                    <option value="{{ $sp }}">{{ $sp }}</option>
                                @endforeach

                            </select>
                        </div>

                        {{-- Doctor --}}
                        <div class="form-group">
                            <label><strong>Doctor *</strong></label>
                            <select name="doctor_id" id="doctorSelect" class="form-control select2">
                                <option value="">Select Doctor...</option>

                                @foreach ($doctors as $d)
                                    <option value="{{ $d->id }}"
                                        data-specialty="{{ optional($d->doctorProfile)->specialization }}"
                                        data-department="{{ optional($d->doctorProfile)->department_id }}">
                                        {{ $d->name }}
                                        @if(optional($d->doctorProfile)->specialization)
                                            — {{ optional($d->doctorProfile)->specialization }}
                                        @endif
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- Department --}}
                        <div class="form-group">
                            <label><strong>Department *</strong></label>
                            <select name="department_id" id="departmentSelect" class="form-control select2">
                                <option value="">Select Department...</option>

                                @foreach ($departments as $dep)
                                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        {{-- Appointment Date --}}
                        <div class="form-group">
                            <label><strong>Appointment Date *</strong></label>
                            <input type="date" 
                                   name="appointment_date" 
                                   value="{{ old('appointment_date', date('Y-m-d')) }}"
                                   class="form-control">
                        </div>

                        {{-- Time Slot --}}
                        <div class="form-group">
                            <label><strong>Time Slot *</strong></label>
                            <select name="appointment_time" id="appointment_time" class="form-control">
                                <option value="">-- Select Time Slot --</option>
                            </select>
                        </div>

                        {{-- Status --}}
                        <div class="form-group">
                            <label><strong>Status *</strong></label>
                            <select name="status" class="form-control select2">
                                @foreach(['Pending','CheckedIn','InConsultation','Completed','Cancelled'] as $s)
                                    <option {{ old('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-md-6">
            <div class="widget-box">
                <div class="widget-header">
                    <h5 class="widget-title">Visit & Medical Information</h5>
                </div>

                <div class="widget-body">
                    <div class="widget-main">

                        {{-- Visit Type --}}
                        <div class="form-group">
                            <label><strong>Visit Type</strong></label>
                            <select name="visit_type" class="form-control select2">
                                <option value="OPD" {{ old('visit_type')=='OPD' ? 'selected':'' }}>OPD</option>
                                <option value="IPD" {{ old('visit_type')=='IPD' ? 'selected':'' }}>IPD</option>
                                <option value="Emergency" {{ old('visit_type')=='Emergency' ? 'selected':'' }}>Emergency</option>
                            </select>
                        </div>

                        {{-- Appointment Type --}}
                        <div class="form-group">
                            <label><strong>Appointment Type</strong></label>
                            <select name="appointment_type" class="form-control select2">
                                <option value="Walk-In">Walk-In</option>
                                <option value="Telephonic">Telephonic</option>
                                <option value="Referral">Referral</option>
                            </select>
                        </div>

                        {{-- Chief Complaint --}}
                        <div class="form-group">
                            <label><strong>Chief Complaint</strong></label>
                            <textarea name="chief_complaint" class="form-control">{{ old('chief_complaint') }}</textarea>
                        </div>

                        {{-- Referral --}}
                        <div class="form-group">
                            <label><strong>Referral</strong></label>
                            <input type="text" name="referral" value="{{ old('referral') }}" class="form-control">
                        </div>

                        {{-- Priority --}}
                        <div class="form-group">
                            <label><strong>Priority</strong></label>
                            <select name="priority" class="form-control select2">
                                <option value="Normal">Normal</option>
                                <option value="High">High</option>
                                <option value="Emergency">Emergency</option>
                            </select>
                        </div>

                        {{-- Notes --}}
                        <div class="form-group">
                            <label><strong>Notes</strong></label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <hr>
    <div class="text-center">
        <button type="submit" class="btn btn-success btn-lg">
            <i class="fa fa-check"></i> Create Appointment
        </button>
    </div>

</form>

@endsection
