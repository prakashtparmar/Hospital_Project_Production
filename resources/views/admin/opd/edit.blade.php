@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('opd.index') }}">OPD Visits</a>
        </li>
        <li class="active">Edit OPD Visit</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">
        <i class="ace-icon fa fa-edit"></i> Edit OPD Visit
    </h4>
</div>

{{-- Validation Errors --}}
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade in">
    <button class="close" data-dismiss="alert">&times;</button>
    <strong><i class="ace-icon fa fa-warning"></i> Errors found:</strong>
    <ul class="mt-2 mb-0">
        @foreach ($errors->all() as $error)
            <li>• {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-xs-12">

        <div class="widget-box">
            <div class="widget-header">
                <h5 class="widget-title"><i class="fa fa-hospital-o"></i> OPD Visit Details</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    @can('opd.edit')
                    <form method="POST" action="{{ route('opd.update', $opd->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            {{-- PATIENT (Disabled but submitted through hidden input) --}}
<div class="col-md-4 mb-3">
    <label><strong>Patient *</strong></label>

    {{-- Hidden field to submit value --}}
    <input type="hidden" name="patient_id" value="{{ $opd->patient_id }}">

    {{-- Disabled dropdown for display --}}
    <select class="form-control" disabled>
        @foreach ($patients as $p)
            <option value="{{ $p->id }}"
                {{ $p->id == $opd->patient_id ? 'selected' : '' }}>
                {{ $p->patient_id }} - {{ $p->full_name }}
            </option>
        @endforeach
    </select>
</div>


                            {{-- DEPARTMENT --}}
                            <div class="col-md-4 mb-3">
                                <label><strong>Department</strong></label>
                                <select name="department_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach ($departments as $d)
                                        <option value="{{ $d->id }}"
                                            {{ $d->id == $opd->department_id ? 'selected' : '' }}>
                                            {{ $d->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- DOCTOR --}}
                            <div class="col-md-4 mb-3">
                                <label><strong>Doctor</strong></label>
                                <select name="doctor_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach ($doctors as $dr)
                                        <option value="{{ $dr->id }}"
                                            {{ $dr->id == $opd->doctor_id ? 'selected' : '' }}>
                                            {{ $dr->name }} (Available Today)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- VISIT DATE --}}
                            <div class="col-md-4 mb-3">
                                <label><strong>Visit Date *</strong></label>
                                <input type="date"
                                       name="visit_date"
                                       class="form-control"
                                       value="{{ $opd->visit_date }}"
                                       required>
                            </div>

                            {{-- BP --}}
                            <div class="col-md-4 mb-3">
                                <label><strong>Blood Pressure (BP)</strong></label>
                                <input name="bp"
                                       class="form-control"
                                       value="{{ $opd->bp }}">
                            </div>

                            {{-- Temperature --}}
                            <div class="col-md-4 mb-3">
                                <label><strong>Temperature</strong></label>
                                <input name="temperature"
                                       class="form-control"
                                       value="{{ $opd->temperature }}">
                            </div>

                            {{-- Pulse --}}
                            <div class="col-md-4 mb-3">
                                <label><strong>Pulse</strong></label>
                                <input name="pulse"
                                       class="form-control"
                                       value="{{ $opd->pulse }}">
                            </div>

                            {{-- Weight --}}
                            <div class="col-md-4 mb-3">
                                <label><strong>Weight</strong></label>
                                <input name="weight"
                                       class="form-control"
                                       value="{{ $opd->weight }}">
                            </div>

                            {{-- Symptoms --}}
                            <div class="col-md-12 mb-3">
                                <label><strong>Symptoms</strong></label>
                                <textarea name="symptoms"
                                          class="form-control"
                                          rows="2">{{ $opd->symptoms }}</textarea>
                            </div>

                            {{-- Diagnosis --}}
                            <div class="col-md-12 mb-3">
                                <label><strong>Diagnosis</strong></label>
                                <textarea name="diagnosis"
                                          class="form-control"
                                          rows="2">{{ $opd->diagnosis }}</textarea>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-4 mb-3">
                                <label><strong>Status</strong></label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ $opd->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $opd->status == 0 ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>

                        </div>

                        <div class="text-right mt-3">

                            <a href="{{ route('opd.index') }}" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>

                            <button class="btn btn-primary">
                                <i class="fa fa-save"></i> Update OPD Visit
                            </button>

                        </div>

                    </form>
                    @endcan

                    @cannot('opd.edit')
                        <div class="alert alert-warning">
                            <i class="fa fa-lock"></i> You do not have permission to edit OPD visits.
                        </div>
                    @endcannot

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
