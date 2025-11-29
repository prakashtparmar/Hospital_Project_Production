@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('opd.index') }}">OPD Visits</a>
        </li>
        <li class="active">OPD Details</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">
        <i class="fa fa-eye"></i> OPD Visit Details
    </h4>
</div>

<div class="row">
    <div class="col-xs-12">

        <div class="widget-box">
            <div class="widget-header">
                <h5 class="widget-title"><i class="fa fa-hospital-o"></i> OPD Information</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <table class="table table-striped table-bordered">
                        <tr>
                            <th width="200">OPD Number</th>
                            <td>{{ $opd->opd_no }}</td>
                        </tr>

                        <tr>
                            <th>Patient</th>
                            <td>{{ $opd->patient->full_name }}</td>
                        </tr>

                        <tr>
                            <th>Doctor</th>
                            <td>{{ $opd->doctor->name ?? '—' }}</td>
                        </tr>

                        <tr>
                            <th>Department</th>
                            <td>{{ $opd->department->name ?? '—' }}</td>
                        </tr>

                        <tr>
                            <th>Visit Date</th>
                            <td>{{ \Carbon\Carbon::parse($opd->visit_date)->format('d M, Y') }}</td>
                        </tr>
                    </table>

                    <hr>

                    <h4><i class="fa fa-file-text"></i> Clinical Information</h4>

                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Symptoms</th>
                            <td>{!! nl2br(e($opd->symptoms)) !!}</td>
                        </tr>

                        <tr>
                            <th>Diagnosis</th>
                            <td>{!! nl2br(e($opd->diagnosis)) !!}</td>
                        </tr>
                    </table>

                    <hr>

                    <h4><i class="fa fa-heartbeat"></i> Vitals</h4>

                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Blood Pressure (BP)</th>
                            <td>{{ $opd->bp ?: '—' }}</td>
                        </tr>

                        <tr>
                            <th>Temperature</th>
                            <td>{{ $opd->temperature ?: '—' }}</td>
                        </tr>

                        <tr>
                            <th>Pulse</th>
                            <td>{{ $opd->pulse ?: '—' }}</td>
                        </tr>

                        <tr>
                            <th>Weight</th>
                            <td>{{ $opd->weight ?: '—' }}</td>
                        </tr>
                    </table>

                    <div class="text-right mt-3">
                        <a href="{{ route('opd.index') }}" class="btn btn-default">
                            <i class="fa fa-arrow-left"></i> Back to List
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
