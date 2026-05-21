@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li><a href="{{ route('doctors.index') }}">Doctors</a></li>
        <li class="active">Add Doctor Profile</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Add Doctor Profile</h4>
</div>

{{-- Validation Errors --}}
@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.
    <ul class="mt-2 mb-2">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-header"><strong>Create Doctor Profile</strong></div>

    <div class="card-body">
        <form action="{{ route('doctors.store') }}" method="POST">
            @csrf

            <div class="row">

                {{-- USER --}}
                <div class="col-md-6 mb-3">
                    <label><strong>Select User</strong></label>
                    <select name="user_id" class="form-control" required>
                        <option value="">-- Select User --</option>
                        @foreach ($users as $u)
                            <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }} ({{ $u->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- DEPARTMENT --}}
                <div class="col-md-6 mb-3">
                    <label><strong>Department</strong></label>
                    <select name="department_id" class="form-control">
                        <option value="">-- Select Department --</option>
                        @foreach ($departments as $d)
                            <option value="{{ $d->id }}" {{ old('department_id') == $d->id ? 'selected' : '' }}>
                                {{ $d->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- SPECIALIZATION --}}
                <div class="col-md-6 mb-3">
                    <label><strong>Specialization</strong></label>
                    <input type="text" name="specialization" class="form-control"
                           value="{{ old('specialization') }}">
                </div>

                {{-- QUALIFICATION --}}
                <div class="col-md-6 mb-3">
                    <label><strong>Qualification</strong></label>
                    <input type="text" name="qualification" class="form-control"
                           value="{{ old('qualification') }}">
                </div>

                {{-- REGISTRATION NO --}}
                <div class="col-md-6 mb-3">
                    <label><strong>Registration Number</strong></label>
                    <input type="text" name="registration_no" class="form-control"
                           value="{{ old('registration_no') }}">
                </div>

                {{-- CONSULTATION FEE --}}
                <div class="col-md-6 mb-3">
                    <label><strong>Consultation Fee (₹)</strong></label>
                    <input type="number" step="0.01" name="consultation_fee" class="form-control"
                           value="{{ old('consultation_fee') }}">
                </div>

                {{-- BIOGRAPHY --}}
                <div class="col-md-12 mb-3">
                    <label><strong>Biography</strong></label>
                    <textarea name="biography" rows="4" class="form-control">{{ old('biography') }}</textarea>
                </div>

                <div class="col-md-12">
                    <button class="btn btn-primary">
                        <i class="fa fa-save"></i> Save Doctor Profile
                    </button>

                    <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection
