@extends('layouts.auth')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Doctor OPD Schedule</h4>
        <a href="{{ route('doctor-schedule.create') }}" class="btn btn-primary btn-sm">Add Schedule</a>
    </div>

    <div class="card-body">

        <table class="table table-bordered">
            <tr>
                <th>Doctor</th>
                <th>Department</th>
                <th>Day</th>
                <th>Time</th>
                <th>Slot Duration</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            @foreach($schedules as $s)
            <tr>
                <td>{{ $s->doctor->name }}</td>
                <td>{{ $s->department->name ?? '-' }}</td>
                <td>{{ $s->day }}</td>
                <td>{{ $s->start_time }} - {{ $s->end_time }}</td>
                <td>{{ $s->slot_duration }} mins</td>
                <td>{{ $s->status ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a class="btn btn-sm btn-warning" href="{{ route('doctor-schedule.edit', $s->id) }}">Edit</a>
                    <form class="d-inline" method="POST" action="{{ route('doctor-schedule.destroy', $s->id) }}">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete?')" class="btn btn-sm btn-danger">Del</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>

        {{ $schedules->links() }}

    </div>
</div>

@endsection
