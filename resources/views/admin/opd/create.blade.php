@extends('layouts.app')

@section('title', 'Add OPD Visit')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
        <li><a href="{{ route('opd.index') }}">OPD Visits</a></li>
        <li class="active">Add OPD Visit</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h1>
        OPD Management
        <small><i class="ace-icon fa fa-angle-double-right"></i> Add OPD Visit</small>

        <a href="{{ route('opd.index') }}" class="btn btn-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </h1>
</div>

{{-- Validation Errors --}}
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

@can('opd.create')

<form method="POST" action="{{ route('opd.store') }}">
@csrf

<div class="row">

    {{-- LEFT COLUMN --------------------------------------------------------- --}}
    <div class="col-md-6">
        <div class="widget-box">
            <div class="widget-header">
                <h5 class="widget-title"><i class="fa fa-user-md"></i> Patient & Visit Details</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    {{-- Patient --}}
                    <div class="form-group">
                        <label><strong>Patient *</strong></label>
                        <select name="patient_id" class="form-control select2" required>
                            <option value="">Select Patient...</option>
                            @foreach ($patients as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->patient_id }} - {{ $p->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Department --}}
                    <div class="form-group">
                        <label><strong>Department</strong></label>
                        <select name="department_id" id="departmentSelect" class="form-control select2">

                            <option value="">Select Department...</option>
                            @foreach ($departments as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Doctor --}}
                    <div class="form-group">
    <label><strong>Doctor</strong></label>
    <select name="doctor_id" id="doctorSelect" class="form-control select2">
        <option value="">Select Doctor...</option>

        @foreach ($doctors as $dr)
            <option 
                value="{{ $dr->id }}"
                data-specialty="{{ $dr->doctorProfile->specialty ?? '' }}"
                data-department="{{ $dr->doctorProfile->department_id ?? '' }}"
            >
                {{ $dr->name }} (Available Today)
            </option>
        @endforeach
    </select>
</div>


                    {{-- Visit Date --}}
                    <div class="form-group">
                        <label><strong>Visit Date *</strong></label>
                        <input type="date" 
                               name="visit_date" 
                               value="{{ date('Y-m-d') }}"
                               class="form-control"
                               required>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label><strong>Status</strong></label>
                        <select name="status" class="form-control select2">
                            <option value="1">Active</option>
                            <option value="0">Closed</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN -------------------------------------------------------- --}}
    <div class="col-md-6">
        <div class="widget-box">
            <div class="widget-header">
                <h5 class="widget-title"><i class="fa fa-stethoscope"></i> Vitals & Clinical Information</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    {{-- BP --}}
                    <div class="form-group">
                        <label><strong>Blood Pressure (BP)</strong></label>
                        <input name="bp" class="form-control" placeholder="e.g. 120/80">
                    </div>

                    {{-- Temperature --}}
                    <div class="form-group">
                        <label><strong>Temperature</strong></label>
                        <input name="temperature" class="form-control" placeholder="e.g. 98.6°F">
                    </div>

                    {{-- Pulse --}}
                    <div class="form-group">
                        <label><strong>Pulse</strong></label>
                        <input name="pulse" class="form-control">
                    </div>

                    {{-- Weight --}}
                    <div class="form-group">
                        <label><strong>Weight</strong></label>
                        <input name="weight" class="form-control" placeholder="kg">
                    </div>

                    {{-- Symptoms --}}
                    <div class="form-group">
                        <label><strong>Symptoms</strong></label>
                        <textarea name="symptoms" class="form-control" rows="2"></textarea>
                    </div>

                    {{-- Diagnosis --}}
                    <div class="form-group">
                        <label><strong>Diagnosis</strong></label>
                        <textarea name="diagnosis" class="form-control" rows="2"></textarea>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<hr>

<div class="text-center">
    <button class="btn btn-success btn-lg">
        <i class="fa fa-save"></i> Save OPD Visit
    </button>
</div>

</form>

@else
<div class="alert alert-warning">
    <i class="fa fa-lock"></i> You do not have permission to create OPD visits.
</div>
@endcan

@endsection
