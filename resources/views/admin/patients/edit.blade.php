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
        <li class="active">Edit Patient</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">
        <i class="ace-icon fa fa-edit"></i> Edit Patient
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
                <h5 class="widget-title"><i class="fa fa-user"></i> Patient Information</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    @can('patients.edit')
                    <form method="POST" action="{{ route('patients.update', $patient->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label><strong>First Name *</strong></label>
                                <input name="first_name" 
                                       class="form-control"
                                       value="{{ old('first_name', $patient->first_name) }}"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Last Name</strong></label>
                                <input name="last_name" 
                                       class="form-control"
                                       value="{{ old('last_name', $patient->last_name) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label><strong>Gender *</strong></label>
                                <select name="gender" class="form-control" required>
                                    <option value="">-- Select --</option>
                                    <option {{ $patient->gender=='Male'?'selected':'' }}>Male</option>
                                    <option {{ $patient->gender=='Female'?'selected':'' }}>Female</option>
                                    <option {{ $patient->gender=='Other'?'selected':'' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label><strong>Age</strong></label>
                                <input name="age"
                                       type="number"
                                       class="form-control"
                                       value="{{ old('age', $patient->age) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label><strong>Phone</strong></label>
                                <input name="phone"
                                       class="form-control"
                                       value="{{ old('phone', $patient->phone) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Email</strong></label>
                                <input name="email"
                                       type="email"
                                       class="form-control"
                                       value="{{ old('email', $patient->email) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Department</strong></label>
                                <select name="department_id" class="form-control">
                                    <option value="">-- Select --</option>

                                    @foreach ($departments as $d)
                                        <option value="{{ $d->id }}"
                                            {{ $patient->department_id == $d->id ? 'selected' : '' }}>
                                            {{ $d->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label><strong>Address</strong></label>
                                <textarea name="address"
                                          class="form-control"
                                          rows="2">{{ old('address', $patient->address) }}</textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label><strong>Status</strong></label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ $patient->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $patient->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                        </div>

                        <div class="text-right mt-3">
                            <a href="{{ route('patients.index') }}" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>

                            <button class="btn btn-success">
                                <i class="fa fa-save"></i> Update Patient
                            </button>
                        </div>

                    </form>
                    @endcan

                    @cannot('patients.edit')
                        <div class="alert alert-warning">
                            <i class="fa fa-lock"></i> You do not have permission to edit patients.
                        </div>
                    @endcannot

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
