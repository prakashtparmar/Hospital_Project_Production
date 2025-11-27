@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Patients</h4>
        <a href="{{ route('patients.create') }}" class="btn btn-primary btn-sm">Add Patient</a>
    </div>

    <div class="card-body">

        <form class="mb-3" method="GET">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search patient..."
                   class="form-control">
        </form>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($patients as $p)
                <tr>
                    <td>{{ $p->patient_id }}</td>
                    <td>{{ $p->full_name }}</td>
                    <td>{{ $p->gender }}</td>
                    <td>{{ $p->phone }}</td>
                    <td>{{ $p->department->name ?? '-' }}</td>
                    <td>
                        @if ($p->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('patients.show', $p->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('patients.edit', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('patients.destroy', $p->id) }}" method="POST"
                              class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete this patient?')"
                                    class="btn btn-sm btn-danger">Delete
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

        {{ $patients->links() }}
    </div>
</div>
@endsection
