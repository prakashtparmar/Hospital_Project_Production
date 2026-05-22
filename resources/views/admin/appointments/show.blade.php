@extends('layouts.app')

@section('title', 'Appointment Details')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a>
        </li>
        <li>
            <a href="{{ route('appointments.index') }}">Appointments</a>
        </li>
        <li class="active">Details</li>
    </ul>
</div>
@endsection

@section('content')

<style>
    .appointment-detail-table th {
        width: 28%;
        color: #555;
        background: #f8f8f8;
        vertical-align: middle !important;
    }

    .appointment-detail-table td {
        vertical-align: middle !important;
    }

    .appointment-detail-table .detail-text {
        white-space: pre-line;
    }
</style>

<div class="page-header">
    <h1>
        Appointment Details
        <small><i class="ace-icon fa fa-angle-double-right"></i> View Full Information</small>

        <a href="{{ route('appointments.index') }}" class="btn btn-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </h1>
</div>

<div class="row">
    <div class="col-xs-12">

        <div class="widget-box">
            <div class="widget-header">
                <h5 class="widget-title"><i class="fa fa-info-circle"></i> Appointment Information</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    @php
                        $statusClass = match ($appointment->status) {
                            'Pending'         => 'label-warning',
                            'CheckedIn'       => 'label-info',
                            'InConsultation'  => 'label-primary',
                            'Completed'       => 'label-success',
                            'Cancelled'       => 'label-danger',
                            default           => 'label-default'
                        };
                    @endphp

                    <table class="table table-striped table-bordered appointment-detail-table">
                        <tbody>

                        <tr>
                            <th>Patient</th>
                            <td>
                                <strong>{{ optional($appointment->patient)->full_name ?? '---' }}</strong>
                                @if(optional($appointment->patient)->patient_id)
                                    <small class="text-muted">({{ $appointment->patient->patient_id }})</small>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Doctor</th>
                            <td>
                                {{ optional($appointment->doctor)->name ?? '---' }}
                                @if(optional($appointment->doctor->doctorProfile)->specialization)
                                    <small class="text-muted">
                                        - {{ optional($appointment->doctor->doctorProfile)->specialization }}
                                    </small>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Department</th>
                            <td>{{ optional($appointment->department)->name ?? '---' }}</td>
                        </tr>

                        <tr>
                            <th>Appointment Date</th>
                            <td>
                                {{ $appointment->appointment_date
                                    ? \Carbon\Carbon::parse($appointment->appointment_date)->format('d-M-Y')
                                    : '---' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Time Slot</th>
                            <td>
                                {{ $appointment->appointment_time
                                    ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A')
                                    : '---' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Token No.</th>
                            <td>{{ $appointment->token_no ?? '---' }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="label {{ $statusClass }}">
                                    {{ $appointment->status }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Visit Type</th>
                            <td>{{ $appointment->visit_type ?? '---' }}</td>
                        </tr>

                        <tr>
                            <th>Appointment Type</th>
                            <td>{{ $appointment->appointment_type ?? '---' }}</td>
                        </tr>

                        <tr>
                            <th>Priority</th>
                            <td>{{ $appointment->priority ?? '---' }}</td>
                        </tr>

                        <tr>
                            <th>Chief Complaint</th>
                            <td class="detail-text">{{ $appointment->chief_complaint ?? $appointment->reason ?? '---' }}</td>
                        </tr>

                        <tr>
                            <th>Referral</th>
                            <td>{{ $appointment->referral ?? '---' }}</td>
                        </tr>

                        <tr>
                            <th>Notes</th>
                            <td class="detail-text">{{ $appointment->notes ?? '---' }}</td>
                        </tr>

                        </tbody>
                    </table>

                    <div class="text-right mt-3">
                        <a href="{{ route('appointments.index') }}" class="btn btn-default btn-sm">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>

                        @can('appointments.edit')
                        <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        @endcan
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

@endsection
