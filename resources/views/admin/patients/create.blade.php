@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header"><h4>Add Patient</h4></div>

    <div class="card-body">
        <form method="POST" action="{{ route('patients.store') }}">
            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>First Name</label>
                    <input name="first_name" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Last Name</label>
                    <input name="last_name" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Gender</label>
                    <select name="gender" class="form-control">
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Age</label>
                    <input name="age" type="number" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Phone</label>
                    <input name="phone" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input name="email" type="email" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Department</label>
                    <select name="department_id" class="form-control">
                        <option value="">-- Select --</option>
                        @foreach ($departments as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control"></textarea>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

            </div>

            <button class="btn btn-success">Save</button>

        </form>
    </div>
</div>
@endsection
