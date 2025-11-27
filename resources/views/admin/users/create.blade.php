@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header"><h4>Create User</h4></div>

    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input name="email" type="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input name="password" type="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <hr>

            <label>Assign Roles</label>
            <div class="row">
                @foreach ($roles as $role)
                <div class="col-md-4">
                    <label>
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}">
                        {{ $role->name }}
                    </label>
                </div>
                @endforeach
            </div>

            <button class="btn btn-success mt-3">Create User</button>

        </form>
    </div>
</div>
@endsection
