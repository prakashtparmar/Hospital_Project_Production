@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>OPD Visits</h4>
        <a href="{{ route('opd.create') }}" class="btn btn-primary btn-sm">Add OPD Visit</a>
    </div>

    <div class="card-body">

        <form class="mb-3" method="GET">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search patient..."
                   class="form-control">
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>OPD No</th>
                    <th>Patient</th>
                    <th>Visit Date</th>
                    <th>Doctor</th>
                    <th>Department</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($visits as $v)
                <tr>
                    <td>{{ $v->opd_no }}</td>
                    <td>{{ $v->patient->full_name }}</td>
                    <td>{{ $v->visit_date }}</td>
                    <td>{{ $v->doctor->name ?? '-' }}</td>
                    <td>{{ $v->department->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('opd.show', $v->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('opd.edit', $v->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('opd.destroy', $v->id) }}" method="POST" class="d-inline-block">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete?')" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

        {{ $visits->links() }}

    </div>
</div>
@endsection
