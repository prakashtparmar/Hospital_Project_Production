@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Doctor Schedule</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between">
    <h4 class="page-title"><i class="fa fa-clock-o"></i> Doctor OPD Schedule</h4>

    @can('doctor-schedule.create')
    <a href="{{ route('doctor-schedule.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> Add Schedule
    </a>
    @endcan
</div>

<div class="widget-box">
    <div class="widget-header">
        <h5 class="widget-title">Schedule List</h5>
    </div>

    <div class="widget-body">
        <div class="widget-main">

            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Slot</th>
                        <th>Status</th>

                        @canany(['doctor-schedule.edit', 'doctor-schedule.delete'])
                            <th width="150">Actions</th>
                        @endcanany
                    </tr>
                </thead>

                <tbody>
                    @foreach($schedules as $s)
                    <tr>
                        <td>{{ $s->doctor->name }}</td>
                        <td>{{ $s->department->name ?? '-' }}</td>
                        <td>{{ $s->day }}</td>
                        <td>{{ date('h:i A', strtotime($s->start_time)) }} - {{ date('h:i A', strtotime($s->end_time)) }}</td>
                        <td>{{ $s->slot_duration }} mins</td>
                        <td>
                            @if($s->status)
                                <span class="label label-success">Active</span>
                            @else
                                <span class="label label-danger">Inactive</span>
                            @endif
                        </td>

                        @canany(['doctor-schedule.edit', 'doctor-schedule.delete'])
                        <td>
                            @can('doctor-schedule.edit')
                            <a href="{{ route('doctor-schedule.edit', $s->id) }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-pencil"></i>
                            </a>
                            @endcan

                            @can('doctor-schedule.delete')
                            <form action="{{ route('doctor-schedule.destroy', $s->id) }}"
                                  method="POST" class="d-inline-block"
                                  onsubmit="return confirm('Delete schedule?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </td>
                        @endcanany

                    </tr>
                    @endforeach
                </tbody>

            </table>

            {{ $schedules->links() }}

        </div>
    </div>
</div>

@endsection
