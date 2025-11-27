@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Doctors</h4>
        <a href="{{ route('doctors.create') }}" class="btn btn-primary btn-sm">Add Doctor</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <th>Specialization</th>
                <th>Department</th>
                <th>Fee</th>
                <th>Actions</th>
            </tr>

            @foreach($doctors as $d)
            <tr>
                <td>{{ $d->name }}</td>
                <td>{{ $d->doctorProfile->specialization ?? '-' }}</td>
                <td>{{ $d->doctorProfile->department->name ?? '-' }}</td>
                <td>{{ $d->doctorProfile->consultation_fee ?? '0' }}</td>
                <td>
                    <a href="{{ route('doctors.edit',$d->id) }}" class="btn btn-warning btn-sm">Edit</a>
                </td>
            </tr>
            @endforeach
        </table>

        {{ $doctors->links() }}
    </div>
</div>
@endsection
