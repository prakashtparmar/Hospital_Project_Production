@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header"><h4>Create Role</h4></div>

    <div class="card-body">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Role Name</label>
                <input name="name" class="form-control" required>
            </div>

            <label>Assign Permissions</label>
            <div class="row">
                @foreach ($permissions as $permission)
                <div class="col-md-4">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                        {{ $permission->name }}
                    </label>
                </div>
                @endforeach
            </div>

            <button class="btn btn-success mt-3">Create Role</button>
        </form>
    </div>
</div>
@endsection
