@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header"><h4>Edit User</h4></div>

    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Name</label>
                <input name="name" value="{{ $user->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input name="email" value="{{ $user->email }}" type="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>New Password (optional)</label>
                <input name="password" type="password" class="form-control">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" @if($user->status) selected @endif>Active</option>
                    <option value="0" @if(!$user->status) selected @endif>Inactive</option>
                </select>
            </div>

            <hr>

            <label>Assign Roles</label>
            <div class="row">
                @foreach ($roles as $role)
                <div class="col-md-4">
                    <label>
                        <input type="checkbox" 
                               name="roles[]" 
                               value="{{ $role->name }}"
                               @if($user->hasRole($role->name)) checked @endif>

                        {{ $role->name }}
                    </label>
                </div>
                @endforeach
            </div>

            <button class="btn btn-success mt-3">Update User</button>

        </form>
    </div>
</div>
@endsection
