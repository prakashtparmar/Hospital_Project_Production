@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('radiology-requests.index') }}">Radiology Requests</a>
        </li>
        <li class="active">New Request</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">New Radiology Request</h4>
</div>

<div class="row">
    <div class="col-xs-12 col-md-8">

        <form method="POST" action="{{ route('radiology-requests.store') }}" class="form-horizontal">
            @csrf

            {{-- Patient --}}
            <div class="form-group">
                <label class="control-label">Patient</label>
                <select name="patient_id" class="form-control" required>
                    <option value="">-- Select Patient --</option>
                    @foreach($patients as $p)
                        <option value="{{ $p->id }}" {{ old('patient_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->first_name }} {{ $p->last_name }}

                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Doctor --}}
            <div class="form-group">
                <label class="control-label">Referred Doctor</label>
                <select name="doctor_id" class="form-control" required>
                    <option value="">-- Select Doctor --</option>
                    @foreach($doctors as $d)
                        <option value="{{ $d->id }}" {{ old('doctor_id') == $d->id ? 'selected' : '' }}>
                            {{ $d->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tests --}}
            <div class="form-group">
                <label class="control-label">Radiology Tests</label>

                <div class="row">
                    @foreach($tests as $t)
                        <div class="col-xs-6 col-md-4">
                            <label class="inline">
                                <input
                                    type="checkbox"
                                    class="ace"
                                    name="test_id[]"
                                    value="{{ $t->id }}"
                                    {{ (is_array(old('test_id')) && in_array($t->id, old('test_id'))) ? 'checked' : '' }}>
                                <span class="lbl"> {{ $t->name }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Actions --}}
            <div class="form-group">
                @can('radiology-requests.create')
                <button type="submit" class="btn btn-success">
                    <i class="ace-icon fa fa-save"></i> Submit Request
                </button>
                @endcan

                <a href="{{ route('radiology-requests.index') }}" class="btn btn-default">
                    <i class="ace-icon fa fa-arrow-left"></i> Back
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
