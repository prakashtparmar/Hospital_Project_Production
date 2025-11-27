@extends('layouts.auth')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Medicine Issues</h4>
        <a href="{{ route('issue-medicines.create') }}" class="btn btn-primary btn-sm">Issue Medicine</a>
    </div>

    <div class="card-body">

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Patient</th>
                <th>Date</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>

            @foreach($issues as $i)
            <tr>
                <td>{{ $i->id }}</td>
                <td>{{ $i->patient->full_name }}</td>
                <td>{{ $i->issue_date }}</td>
                <td>{{ $i->total_amount }}</td>
                <td>
                    <a href="{{ route('issue-medicines.show',$i->id) }}" class="btn btn-info btn-sm">View</a>
                </td>
            </tr>
            @endforeach

        </table>

        {{ $issues->links() }}

    </div>
</div>

@endsection
