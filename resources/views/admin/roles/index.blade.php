@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Roles</h4>
        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">Add Role</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Permissions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>
                        @foreach ($role->permissions as $p)
                            <span class="badge bg-info">{{ $p->name }}</span>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
