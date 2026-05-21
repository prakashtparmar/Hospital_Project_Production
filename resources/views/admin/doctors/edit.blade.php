@extends('layouts.app')

@section('content')

<div class="page-header">
    <h4 class="page-title">Edit Doctor Profile</h4>
</div>

<form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">

        <div class="col-md-6">
            <label>User</label>
            <input type="text" class="form-control" value="{{ $doctor->user->name }}" disabled>
        </div>

        <div class="col-md-6">
            <label>Department</label>
            <select name="department_id" class="form-control">
                @foreach ($departments as $d)
                    <option value="{{ $d->id }}" 
                        {{ $doctor->department_id == $d->id ? 'selected' : '' }}>
                        {{ $d->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mt-3">
            <label>Specialization</label>
            <input type="text" name="specialization" class="form-control" 
                value="{{ $doctor->specialization }}">
        </div>

        <div class="col-md-6 mt-3">
            <label>Qualification</label>
            <input type="text" name="qualification" class="form-control"
                value="{{ $doctor->qualification }}">
        </div>

        <div class="col-md-6 mt-3">
            <label>Registration No</label>
            <input type="text" name="registration_no" class="form-control"
                value="{{ $doctor->registration_no }}">
        </div>

        <div class="col-md-6 mt-3">
            <label>Consultation Fee</label>
            <input type="number" step="0.01" name="consultation_fee" class="form-control"
                value="{{ $doctor->consultation_fee }}">
        </div>

        <div class="col-md-12 mt-3">
            <label>Biography</label>
            <textarea name="biography" rows="4" class="form-control">{{ $doctor->biography }}</textarea>
        </div>

        <div class="col-md-12 mt-3">
            <button class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
        </div>

    </div>
</form>

@endsection
