@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li><a href="{{ route('appointments.index') }}">Appointments</a></li>
        <li class="active">Edit Appointment</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Edit Appointment</h4>

    <a href="{{ route('appointments.index') }}" class="btn btn-default btn-sm">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade in">
    <button class="close" data-dismiss="alert">×</button>
    <i class="fa fa-check"></i> {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade in">
    <button class="close">×</button>
    <strong>Whoops!</strong>
    <ul>
        @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
        @endforeach
    </ul>
</div>
@endif


<div class="card">
    <div class="card-header"><strong>Edit Appointment</strong></div>
    <div class="card-body">

        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                {{-- LEFT COLUMN --}}
                <div class="col-md-6">

                    {{-- Patient --}}
                    <div class="form-group">
                        <label><strong>Patient *</strong></label>
                        <select name="patient_id" id="patientSelect" class="form-control select2">
                            <option value="">Select Patient...</option>
                            @foreach ($patients as $p)
                            <option value="{{ $p->id }}"
                                {{ $appointment->patient_id == $p->id ? 'selected' : '' }}>
                                {{ $p->patient_id }} - {{ $p->first_name }} {{ $p->last_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Specialty --}}
                    <div class="form-group">
                        <label><strong>Specialty *</strong></label>
                        <select id="specialtySelect" class="form-control select2">
                            <option value="">Select Specialty...</option>
                            <option value="__ALL__">All</option>

                            @foreach($doctors->map(fn($d)=>optional($d->doctorProfile)->specialization)->filter()->unique() as $sp)
                            <option value="{{ $sp }}"
                                {{ optional($appointment->doctor->doctorProfile)->specialization == $sp ? 'selected' : '' }}>
                                {{ $sp }}
                            </option>
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
                                data-department="{{ optional($d->doctorProfile)->department_id }}"
                                {{ $appointment->doctor_id == $d->id ? 'selected' : '' }}>
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
                                <option value="{{ $dep->id }}"
                                    {{ $appointment->department_id == $dep->id ? 'selected' : '' }}>
                                    {{ $dep->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date --}}
                    <div class="form-group">
                        <label><strong>Appointment Date *</strong></label>
                        <input type="date" name="appointment_date" class="form-control"
                            value="{{ $appointment->appointment_date }}">
                    </div>

                    {{-- Time --}}
                    <div class="form-group">
    <label><strong>Time Slot *</strong></label>
    <select name="appointment_time" id="appointment_time" class="form-control">
        <option value="">-- Select Time Slot --</option>

        <option value="{{ $appointment->appointment_time }}" selected>
            {{ $appointment->appointment_time }}
        </option>
    </select>
</div>


                    {{-- Status --}}
                    <div class="form-group">
                        <label><strong>Status *</strong></label>
                        <select name="status" class="form-control select2">
                            @foreach(['Pending','CheckedIn','InConsultation','Completed','Cancelled'] as $s)
                                <option value="{{ $s }}"
                                    {{ $appointment->status == $s ? 'selected' : '' }}>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                {{-- RIGHT COLUMN --}}
                <div class="col-md-6">

                    <div class="form-group">
                        <label><strong>Visit Type</strong></label>
                        <select name="visit_type" class="form-control select2">
                            @foreach(['OPD','IPD','Emergency'] as $vt)
                                <option value="{{ $vt }}"
                                    {{ $appointment->visit_type == $vt ? 'selected' : '' }}>
                                    {{ $vt }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><strong>Appointment Type</strong></label>
                        <select name="appointment_type" class="form-control select2">
                            @foreach(['Walk-In','Telephonic','Referral'] as $at)
                                <option value="{{ $at }}"
                                    {{ $appointment->appointment_type == $at ? 'selected' : '' }}>
                                    {{ $at }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><strong>Chief Complaint</strong></label>
                        <textarea name="chief_complaint" class="form-control">{{ $appointment->chief_complaint }}</textarea>
                    </div>

                    <div class="form-group">
                        <label><strong>Referral</strong></label>
                        <input type="text" name="referral" class="form-control"
                            value="{{ $appointment->referral }}">
                    </div>

                    <div class="form-group">
                        <label><strong>Priority</strong></label>
                        <select name="priority" class="form-control select2">
                            @foreach(['Normal','High','Emergency'] as $pr)
                                <option value="{{ $pr }}"
                                    {{ $appointment->priority == $pr ? 'selected' : '' }}>
                                    {{ $pr }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><strong>Notes</strong></label>
                        <textarea name="notes" class="form-control" rows="3">{{ $appointment->notes }}</textarea>
                    </div>

                </div>
            </div>

            <hr>

            <div class="text-center">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fa fa-check"></i> Update Appointment
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
