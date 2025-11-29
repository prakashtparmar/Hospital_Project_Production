@extends('layouts.app')

@section('breadcrumbs')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="active">Appointments</li>
        </ul>
    </div>
@endsection

@section('content')

    <div class="page-header">
        <h4 class="page-title">
            <i class="fa fa-calendar"></i> Appointments
        </h4>
    </div>

    {{-- ✅ SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade in" style="margin-bottom:15px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="ace-icon fa fa-check"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-xs-12">

            <div class="widget-box">
                <div class="widget-header">
                    <h5 class="widget-title"><i class="fa fa-list"></i> Appointment List</h5>

                    <div class="widget-toolbar">
                        @can('appointments.create')
                            <a href="{{ route('appointments.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Book Appointment
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">

                        @can('appointments.view')
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Token</th>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Department</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th width="180">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($appointments as $a)
                                        <tr>
                                            <td>{{ $a->token_no }}</td>

                                            <td>{{ $a->patient->full_name }}</td>

                                            <td>{{ $a->doctor->name }}</td>

                                            <td>{{ optional($a->department)->name }}</td>

                                            <td>{{ $a->appointment_date }}</td>

                                            <td>{{ $a->appointment_time }}</td>

                                            <td>
                                                @php
                                                    $statusClass = match ($a->status) {
                                                        'Pending'         => 'label-warning',
                                                        'CheckedIn'       => 'label-info',
                                                        'InConsultation'  => 'label-info',
                                                        'Completed'       => 'label-success',
                                                        'Cancelled'       => 'label-danger',
                                                        default           => 'label-default',
                                                    };
                                                @endphp

                                                <span class="label {{ $statusClass }}">
                                                    {{ $a->status }}
                                                </span>
                                            </td>

                                            <td>
                                                @can('appointments.view')
                                                    <a href="{{ route('appointments.show', $a->id) }}" class="btn btn-info btn-xs">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                @endcan

                                                @can('appointments.edit')
                                                    <a href="{{ route('appointments.edit', $a->id) }}" class="btn btn-warning btn-xs">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                @endcan

                                                @can('appointments.delete')
                                                    <form class="d-inline" method="POST"
                                                          action="{{ route('appointments.destroy', $a->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('Cancel appointment?')"
                                                                class="btn btn-danger btn-xs">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-2">
                                {{ $appointments->links() }}
                            </div>
                        @endcan

                        @cannot('appointments.view')
                        <div class="alert alert-warning m-3">
                            <i class="fa fa-lock"></i> You do not have permission to view appointments.
                        </div>
                        @endcannot

                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
