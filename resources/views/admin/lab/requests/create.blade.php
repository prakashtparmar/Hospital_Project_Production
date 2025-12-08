@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('lab-requests.index') }}">Lab Requests</a>
        </li>
        <li class="active">Create</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <h4 class="page-title">Create Lab Test Request</h4>

    <a href="{{ route('lab-requests.index') }}" class="btn btn-default btn-sm">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-header">
        <strong>Lab Test Request</strong>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('lab-requests.store') }}">
            @csrf

            <div class="row">

                {{-- PATIENT --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>Patient *</strong></label>
                        <select name="patient_id" class="form-control select2" required>
                            <option value="">Select Patient...</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->patient_id }} - {{ $p->first_name }} {{ $p->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- DOCTOR --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>Referred By Doctor</strong></label>
                        <select name="doctor_id" class="form-control select2">
                            <option value="">-- Optional --</option>
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- TESTS --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label><strong>Select Tests *</strong></label>

                        <div class="row">
                            @foreach($tests as $t)
                                <div class="col-md-4">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="test_id[]" value="{{ $t->id }}">
                                        {{ $t->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <small class="text-muted">
                            Select one or more lab tests
                        </small>
                    </div>
                </div>

            </div>

            <hr>

            <div class="text-center">
                <button class="btn btn-success btn-lg">
                    <i class="fa fa-check"></i> Create Request
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
