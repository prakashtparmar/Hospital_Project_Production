@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header"><h4>Add Doctor Profile</h4></div>

    <div class="card-body">
        <form action="{{ route('doctors.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Select User (Doctor)</label>
                <select name="user_id" class="form-control" required>
                    @foreach(\App\Models\User::role('Doctor')->get() as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Department</label>
                <select name="department_id" class="form-control">
                    @foreach($departments as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Specialization</label>
                <input name="specialization" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Qualification</label>
                <input name="qualification" class="form-control">
            </div>

            <div class="mb-3">
                <label>Registration No</label>
                <input name="registration_no" class="form-control">
            </div>

            <div class="mb-3">
                <label>Consultation Fee</label>
                <input name="consultation_fee" type="number" class="form-control">
            </div>

            <div class="mb-3">
                <label>Biography</label>
                <textarea name="biography" class="form-control"></textarea>
            </div>

            <button class="btn btn-success">Save</button>
        </form>
    </div>
</div>
@endsection
