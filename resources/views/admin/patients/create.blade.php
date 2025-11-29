@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('patients.index') }}">Patients</a>
        </li>
        <li class="active">Add Patient</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">
        <i class="ace-icon fa fa-user-plus"></i> Add Patient
    </h4>
</div>

{{-- Validation Errors --}}
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong><i class="ace-icon fa fa-exclamation-triangle"></i> Errors found:</strong>
    <ul class="mt-2 mb-0">
        @foreach ($errors->all() as $error)
            <li>• {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Success --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <i class="ace-icon fa fa-check"></i>
    {{ session('success') }}
</div>
@endif

<div class="row">
    <div class="col-xs-12">

        <div class="widget-box">
            <div class="widget-header">
                <h5 class="widget-title"><i class="fa fa-plus"></i> Patient Information</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    @can('patients.create')
                    <form method="POST" action="{{ route('patients.store') }}">
                        @csrf

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label><strong>First Name *</strong></label>
                                <input name="first_name" value="{{ old('first_name') }}" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Last Name</strong></label>
                                <input name="last_name" value="{{ old('last_name') }}" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label><strong>Gender *</strong></label>
                                <select name="gender" class="form-control" required>
                                    <option value="">-- Select --</option>
                                    <option value="Male" {{ old('gender')=='Male'?'selected':'' }}>Male</option>
                                    <option value="Female" {{ old('gender')=='Female'?'selected':'' }}>Female</option>
                                    <option value="Other" {{ old('gender')=='Other'?'selected':'' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label><strong>Age</strong></label>
                                <input name="age" type="number" value="{{ old('age') }}" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label><strong>Phone</strong></label>
                                <input name="phone" value="{{ old('phone') }}" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Email</strong></label>
                                <input name="email" type="email" value="{{ old('email') }}" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Department</strong></label>
                                <select name="department_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach ($departments as $d)
                                        <option value="{{ $d->id }}" {{ old('department_id')==$d->id?'selected':'' }}>
                                            {{ $d->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label><strong>Address</strong></label>
                                <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label><strong>Status</strong></label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ old('status')=='1'?'selected':'' }}>Active</option>
                                    <option value="0" {{ old('status')=='0'?'selected':'' }}>Inactive</option>
                                </select>
                            </div>

                        </div>

                        <div class="text-right mt-3">
                            <a href="{{ route('patients.index') }}" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>

                            <button class="btn btn-success">
                                <i class="fa fa-save"></i> Save Patient
                            </button>
                        </div>

                    </form>
                    @endcan

                    @cannot('patients.create')
                        <div class="alert alert-warning">
                            <i class="fa fa-lock"></i> You do not have permission to add patients.
                        </div>
                    @endcannot

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
