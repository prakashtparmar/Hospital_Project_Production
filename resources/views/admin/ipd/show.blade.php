@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('ipd.index') }}">IPD Admissions</a>
        </li>
        <li class="active">IPD Details</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h1>
        IPD Admission Details
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Patient Information
        </small>
    </h1>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">IPD Information</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    {{-- ACTION BUTTONS --}}
                    <div class="mb-3">
                        @if($ipd->status == 1)
                            <a href="{{ route('ipd.discharge.form', $ipd->id) }}"
                               class="btn btn-danger btn-sm">
                                <i class="fa fa-sign-out"></i> Discharge Patient
                            </a>
                        @else
                            <span class="badge badge-success">Discharged</span>
                        @endif

                        @if($ipd->discharge_date)
                            <a href="{{ route('ipd.discharge.pdf', $ipd->id) }}"
                               class="btn btn-primary btn-sm">
                                <i class="fa fa-file-pdf-o"></i> Download Discharge Summary
                            </a>
                        @endif
                    </div>

                    {{-- DETAILS TABLE --}}
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>IPD No</th>
                            <td>{{ $ipd->ipd_no }}</td>
                        </tr>

                        <tr>
                            <th>Patient</th>
                            <td>{{ $ipd->patient->full_name }}</td>
                        </tr>

                        <tr>
                            <th>Doctor</th>
                            <td>{{ $ipd->doctor->name ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Department</th>
                            <td>{{ $ipd->department->name ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Ward</th>
                            <td>{{ $ipd->ward->name ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Room</th>
                            <td>{{ $ipd->room->room_no ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Bed</th>
                            <td>{{ $ipd->bed->bed_no ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Admission Date</th>
                            <td>{{ \Carbon\Carbon::parse($ipd->admission_date)->format('d M Y, h:i A') }}</td>
                        </tr>

                        @if($ipd->discharge_date)
                        <tr>
                            <th>Discharge Date</th>
                            <td>{{ \Carbon\Carbon::parse($ipd->discharge_date)->format('d M Y, h:i A') }}</td>
                        </tr>
                        @endif

                        <tr>
                            <th>Reason for Admission</th>
                            <td>{{ $ipd->admission_reason }}</td>
                        </tr>

                        <tr>
                            <th>Initial Diagnosis</th>
                            <td>{{ $ipd->initial_diagnosis }}</td>
                        </tr>

                        @if($ipd->discharge_summary)
                        <tr>
                            <th>Discharge Summary</th>
                            <td>{{ $ipd->discharge_summary }}</td>
                        </tr>
                        @endif
                    </table>

                    <div class="text-right">
                        <a href="{{ route('ipd.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
