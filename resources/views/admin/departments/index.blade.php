@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Departments</h4>
        <a href="{{ route('departments.create') }}" class="btn btn-primary btn-sm">Add Department</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($departments as $dep)
                <tr>
                    <td>{{ $dep->name }}</td>
                    <td>{{ $dep->code }}</td>
                    <td>
                        @if ($dep->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('departments.edit', $dep->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('departments.destroy', $dep->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $departments->links() }}
    </div>
</div>
@endsection
