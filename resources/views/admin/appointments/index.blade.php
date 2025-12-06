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

    <div class="row">
        <div class="col-xs-12">

            <div class="widget-box">

                <div class="widget-header">
                    <h5 class="widget-title">
                        <i class="fa fa-list"></i> Appointment List
                    </h5>

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

                            <table class="table table-striped table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>Token</th>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Department</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th width="420" class="text-center">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($appointments as $a)
                                                                <tr>

                                                                    <td>{{ $a->token_no }}</td>

                                                                    <td>{{ $a->patient->full_name }}</td>

                                                                    <td>{{ $a->doctor->name }}</td>

                                                                    <td>{{ optional($a->department)->name }}</td>

                                                                    {{-- FORMATTED DATE (04-Dec-2025) --}}
                                                                    <td>
                                                                        {{ $a->appointment_date
                                                ? \Carbon\Carbon::parse($a->appointment_date)->format('d-M-Y')
                                                : '—'
                                        }}
                                                                    </td>

                                                                    {{-- FORMATTED TIME (02:30 PM) --}}
                                                                    <td>
                                                                        {{ $a->appointment_time
                                                ? \Carbon\Carbon::parse($a->appointment_time)->format('h:i A')
                                                : '—'
                                        }}
                                                                    </td>


                                                                    <td>{{ $a->reason ?? '—' }}</td>

                                                                    <td>
                                                                        @php
                                                                            $statusClass = match ($a->status) {
                                                                                'Pending' => 'label-warning',
                                                                                'CheckedIn' => 'label-info',
                                                                                'InConsultation' => 'label-info',
                                                                                'Completed' => 'label-success',
                                                                                'Cancelled' => 'label-danger',
                                                                                default => 'label-default',
                                                                            };
                                                                        @endphp
                                                                        <span class="label {{ $statusClass }}">
                                                                            {{ $a->status }}
                                                                        </span>
                                                                    </td>

                                                                    <td>
                                                                        {{ $a->created_at
                                                ? \Carbon\Carbon::parse($a->created_at)->format('d-M-Y h:i A')
                                                : '—'
                                        }}
                                                                    </td>

                                                                    <td>
                                                                        {{ $a->updated_at
                                                ? \Carbon\Carbon::parse($a->updated_at)->format('d-M-Y h:i A')
                                                : '—'
                                        }}
                                                                    </td>


                                                                    <td class="text-center">

                                                                        <div class="btn-group">

                                                                            {{-- VIEW --}}
                                                                            @can('appointments.view')
                                                                                <a href="{{ route('appointments.show', $a->id) }}" class="btn btn-info btn-sm">
                                                                                    <i class="fa fa-eye"></i> View
                                                                                </a>
                                                                            @endcan

                                                                            {{-- EDIT --}}
                                                                            @can('appointments.edit')
                                                                                <a href="{{ route('appointments.edit', $a->id) }}"
                                                                                    class="btn btn-warning btn-sm">
                                                                                    <i class="fa fa-pencil"></i> Edit
                                                                                </a>
                                                                            @endcan

                                                                            {{-- CONSULT --}}
                                                                            <a href="{{ route('consultations.create', ['appointment_id' => $a->id]) }}"
                                                                                class="btn btn-purple btn-sm">
                                                                                <i class="fa fa-stethoscope"></i> Consult
                                                                            </a>

                                                                            {{-- DELETE --}}
                                                                            @can('appointments.delete')
                                                                                <form method="POST" action="{{ route('appointments.destroy', $a->id) }}"
                                                                                    class="d-inline">
                                                                                    @csrf
                                                                                    @method('DELETE')

                                                                                    <button class="btn btn-danger btn-sm"
                                                                                        onclick="return confirm('Cancel appointment?')">
                                                                                        <i class="fa fa-trash"></i> Delete
                                                                                    </button>
                                                                                </form>
                                                                            @endcan

                                                                            {{-- CONVERT TO OPD --}}
                                                                            @can('opd.create')
                                                                                <form method="POST" action="{{ route('appointments.convert-to-opd', $a->id) }}"
                                                                                    class="d-inline">
                                                                                    @csrf
                                                                                    <button class="btn btn-success btn-sm"
                                                                                        onclick="return confirm('Convert this appointment to OPD visit?')">
                                                                                        <i class="fa fa-sign-in"></i> Convert to OPD
                                                                                    </button>
                                                                                </form>
                                                                            @endcan

                                                                        </div>

                                                                    </td>

                                                                </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-2" style="padding:10px;">
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