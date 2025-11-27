@extends('layouts.auth')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Appointments</h4>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-sm">Book Appointment</a>
    </div>

    <div class="card-body">

        <table class="table table-bordered">
            <tr>
                <th>Token</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            @foreach($appointments as $a)
            <tr>
                <td>{{ $a->token_no }}</td>
                <td>{{ $a->patient->full_name }}</td>
                <td>{{ $a->doctor->name }}</td>
                <td>{{ $a->appointment_date }}</td>
                <td>{{ $a->appointment_time }}</td>
                <td>{{ $a->status }}</td>
                <td>
                    <a href="{{ route('appointments.show',$a->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('appointments.edit',$a->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form class="d-inline" method="POST" action="{{ route('appointments.destroy',$a->id) }}">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Cancel appointment?')" class="btn btn-danger btn-sm">X</button>
                    </form>
                </td>
            </tr>
            @endforeach

        </table>

        {{ $appointments->links() }}
    </div>
</div>

@endsection
