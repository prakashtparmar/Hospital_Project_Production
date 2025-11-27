@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header"><h4>Edit Doctor Profile - {{ $doctor->user->name }}</h4></div>

    <div class="card-body">
        <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
            @csrf
            {{-- Use @method('PUT') for updating resources in Laravel --}}
            @method('PUT')

            {{-- Doctor User --}}
            <div class="mb-3">
                <label>Select User (Doctor)</label>
                {{-- User selection is often disabled or hidden on edit, as you're editing an existing user's profile --}}
                <select name="user_id" class="form-control" required disabled>
                    <option value="{{ $doctor->user->id }}" selected>{{ $doctor->user->name }}</option>
                </select>
                {{-- Include a hidden field to still pass the ID if the select is disabled --}}
                <input type="hidden" name="user_id" value="{{ $doctor->user->id }}">
            </div>

            {{-- Department --}}
            <div class="mb-3">
                <label>Department</label>
                <select name="department_id" class="form-control">
                    @foreach($departments as $dep)
                        <option value="{{ $dep->id }}" {{ $doctor->department_id == $dep->id ? 'selected' : '' }}>
                            {{ $dep->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Specialization --}}
            <div class="mb-3">
                <label>Specialization</label>
                <input name="specialization" class="form-control" required value="{{ old('specialization', $doctor->specialization) }}">
            </div>

            {{-- Qualification --}}
            <div class="mb-3">
                <label>Qualification</label>
                <input name="qualification" class="form-control" value="{{ old('qualification', $doctor->qualification) }}">
            </div>

            {{-- Registration No --}}
            <div class="mb-3">
                <label>Registration No</label>
                <input name="registration_no" class="form-control" value="{{ old('registration_no', $doctor->registration_no) }}">
            </div>

            {{-- Consultation Fee --}}
            <div class="mb-3">
                <label>Consultation Fee</label>
                <input name="consultation_fee" type="number" class="form-control" value="{{ old('consultation_fee', $doctor->consultation_fee) }}">
            </div>

            {{-- Biography --}}
            <div class="mb-3">
                <label>Biography</label>
                <textarea name="biography" class="form-control">{{ old('biography', $doctor->biography) }}</textarea>
            </div>

            <button class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection