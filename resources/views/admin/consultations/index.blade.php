@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Consultations</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h1>
        <i class="fa fa-stethoscope"></i> Consultations
        <a href="{{ route('consultations.create') }}" class="btn btn-primary btn-sm pull-right">
            <i class="fa fa-plus"></i> New Consultation
        </a>
    </h1>
</div>

<div class="row">
    <div class="col-xs-12">

        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Consultation Records</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main no-padding">

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th style="width: 120px;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($consultations as $c)
                                <tr>
                                    <td>{{ $c->id }}</td>

                                    <td>
                                        {{ $c->patient->patient_id }} -
                                        {{ $c->patient->first_name }} {{ $c->patient->last_name }}
                                    </td>

                                    <td>{{ $c->doctor->name }}</td>

                                    <td>
                                        @php
                                            $colors = [
                                                'in_progress' => 'warning',
                                                'completed'   => 'success',
                                                'cancelled'   => 'danger'
                                            ];
                                        @endphp

                                        <span class="badge badge-{{ $colors[$c->status] ?? 'info' }}">
                                            {{ ucfirst(str_replace('_',' ',$c->status)) }}
                                        </span>
                                    </td>

                                    <td>{{ $c->created_at->format('d M Y, h:i A') }}</td>

                                    <td>
                                        <a href="{{ route('consultations.show', $c->id) }}"
                                           class="btn btn-xs btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a href="{{ route('consultations.edit', $c->id) }}"
                                           class="btn btn-xs btn-warning">
                                            <i class="fa fa-pencil"></i>
                                        </a>

                                        <a href="{{ route('consultations.patient-history.pdf', $c->patient_id) }}"
                                           class="btn btn-xs btn-success" title="Full History PDF">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $consultations->links() }}
        </div>

    </div>
</div>

@endsection
