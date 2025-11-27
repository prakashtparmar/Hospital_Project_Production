@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>IPD Admissions</h4>
    </div>

    <div class="card-body">
        <a href="{{ route('ipd.create') }}" class="btn btn-primary mb-3">Admit Patient</a>

        <table class="table table-bordered">
            <tr>
                <th>IPD No</th>
                <th>Patient</th>
                <th>Ward/Room/Bed</th>
                <th>Doctor</th>
                <th>Admission Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            @foreach($admissions as $i)
            <tr>
                <td>{{ $i->ipd_no }}</td>
                <td>{{ $i->patient->full_name }}</td>
                <td>{{ $i->ward->name ?? '' }} / {{ $i->room->room_no ?? '' }} / {{ $i->bed->bed_no ?? '' }}</td>
                <td>{{ $i->doctor->name ?? '-' }}</td>
                <td>{{ $i->admission_date }}</td>
                <td>{{ $i->status ? 'Admitted' : 'Discharged' }}</td>
                <td>
                    <a href="{{ route('ipd.show',$i->id) }}" class="btn btn-info btn-sm">View</a>
                </td>
            </tr>
            @endforeach
        </table>

        {{ $admissions->links() }}
    </div>
</div>
@endsection
