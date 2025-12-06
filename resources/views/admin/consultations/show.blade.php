@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li><a href="{{ route('consultations.index') }}">Consultations</a></li>
        <li class="active">Consultation #{{ $consultation->id }}</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h1>
        <i class="fa fa-stethoscope"></i> Consultation Details

        <div class="pull-right">

            <a href="{{ route('consultations.edit',$consultation->id) }}"
               class="btn btn-warning btn-sm">
                <i class="fa fa-pencil"></i> Edit
            </a>

            <a href="{{ route('consultations.patient-history.pdf',$consultation->patient_id) }}"
               class="btn btn-success btn-sm">
                <i class="fa fa-file-pdf-o"></i> Print Full History
            </a>

            <a href="{{ route('consultations.index') }}"
               class="btn btn-default btn-sm">
                <i class="fa fa-arrow-left"></i> Back
            </a>

        </div>
    </h1>
</div>

<div class="row">
    <div class="col-sm-12">

        {{-- SUMMARY --}}
        <div class="widget-box">
            <div class="widget-header"><h4 class="widget-title">Summary</h4></div>
            <div class="widget-body"><div class="widget-main">

                <table class="table table-bordered">
                    <tr>
                        <th>Patient</th>
                        <td>{{ $consultation->patient->patient_id }} -
                            {{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}
                        </td>
                    </tr>

                    <tr><th>Doctor</th><td>{{ $consultation->doctor->name }}</td></tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            @php
                                $color = [
                                    'in_progress' => 'warning',
                                    'completed'   => 'success',
                                    'cancelled'   => 'danger'
                                ];
                            @endphp

                            <span class="badge badge-{{ $color[$consultation->status] ?? 'info' }}">
                                {{ ucfirst(str_replace('_',' ',$consultation->status)) }}
                            </span>
                        </td>
                    </tr>

                    {{-- FORMATTED DATES --}}
                    <tr>
                        <th>Consultation Started</th>
                        <td>{{ $consultation->started_at ? \Carbon\Carbon::parse($consultation->started_at)->format('d-M-Y h:i A') : '—' }}</td>
                    </tr>

                    <tr>
                        <th>Consultation Ended</th>
                        <td>{{ $consultation->ended_at ? \Carbon\Carbon::parse($consultation->ended_at)->format('d-M-Y h:i A') : 'In Progress' }}</td>
                    </tr>

                    <tr>
                        <th>Linked Appointment</th>
                        <td>
                            @if($consultation->appointment)
                                {{ \Carbon\Carbon::parse($consultation->appointment->appointment_date)->format('d-M-Y') }}
                                {{ \Carbon\Carbon::parse($consultation->appointment->appointment_time)->format('h:i A') }}
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>

                </table>

            </div></div>
        </div>

        {{-- CLINICAL NOTES --}}
        <div class="widget-box">
            <div class="widget-header"><h4 class="widget-title">Clinical Notes</h4></div>
            <div class="widget-body"><div class="widget-main">

                <h5>Chief Complaint</h5><p>{{ $consultation->chief_complaint ?? '—' }}</p>
                <h5>History</h5><p>{{ $consultation->history ?? '—' }}</p>
                <h5>Examination</h5><p>{{ $consultation->examination ?? '—' }}</p>
                <h5>Provisional Diagnosis</h5><p>{{ $consultation->provisional_diagnosis ?? '—' }}</p>
                <h5>Final Diagnosis</h5><p>{{ $consultation->final_diagnosis ?? '—' }}</p>
                <h5>Treatment Plan</h5><p>{{ $consultation->plan ?? '—' }}</p>

            </div></div>
        </div>

        {{-- VITALS --}}
        <div class="widget-box">
            <div class="widget-header"><h4 class="widget-title">Vitals</h4></div>
            <div class="widget-body"><div class="widget-main">

                <table class="table table-bordered">
                    <tr><th>BP</th><td>{{ $consultation->bp }}</td></tr>
                    <tr><th>Pulse</th><td>{{ $consultation->pulse }}</td></tr>
                    <tr><th>Temperature</th><td>{{ $consultation->temperature }}</td></tr>
                    <tr><th>Resp Rate</th><td>{{ $consultation->resp_rate }}</td></tr>
                    <tr><th>SPO2</th><td>{{ $consultation->spo2 }}</td></tr>
                    <tr><th>Weight</th><td>{{ $consultation->weight }}</td></tr>
                    <tr><th>Height</th><td>{{ $consultation->height }}</td></tr>
                </table>

            </div></div>
        </div>

        {{-- PRESCRIPTIONS --}}
        <div class="widget-box">
            <div class="widget-header"><h4 class="widget-title">Prescriptions</h4></div>
            <div class="widget-body"><div class="widget-main">

                @if($consultation->prescriptions->count())

                    @foreach($consultation->prescriptions as $prescription)

                        <div class="alert alert-info">
                            <strong>Prescription Date:</strong>
                            {{ \Carbon\Carbon::parse($prescription->prescribed_on)->format('d-M-Y') }}

                            <a href="{{ route('prescriptions.pdf',$prescription->id) }}"
                               class="btn btn-success btn-xs pull-right">
                                <i class="fa fa-file-pdf-o"></i> PDF
                            </a>
                        </div>

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Drug</th>
                                    <th>Strength</th>
                                    <th>Dose</th>
                                    <th>Route</th>
                                    <th>Frequency</th>
                                    <th>Duration</th>
                                    <th>Instructions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($prescription->items as $item)
                                <tr>
                                    <td>{{ $item->drug_name }}</td>
                                    <td>{{ $item->strength }}</td>
                                    <td>{{ $item->dose }}</td>
                                    <td>{{ $item->route }}</td>
                                    <td>{{ $item->frequency }}</td>
                                    <td>{{ $item->duration }}</td>
                                    <td>{{ $item->instructions }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @endforeach

                @else
                    <p class="text-muted">No prescriptions recorded.</p>
                @endif

            </div></div>
        </div>

        {{-- DOCUMENTS --}}
        <div class="widget-box">
            <div class="widget-header"><h4 class="widget-title">Attached Documents</h4></div>
            <div class="widget-body"><div class="widget-main">

                @if($consultation->documents->count())
                    <ul>
                        @foreach($consultation->documents as $doc)
                            <li style="padding:5px 0;">
                                <i class="fa fa-paperclip"></i>
                                <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank">
                                    {{ $doc->file_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No documents uploaded.</p>
                @endif

            </div></div>
        </div>

    </div>
</div>

{{-- FULL PATIENT HISTORY BLOCK --}}
@include('admin.consultations.partials.history', [
    'history' => $consultation->patient->consultations()
                    ->with(['doctor','prescriptions.items'])
                    ->orderBy('created_at','desc')
                    ->get(),
    'patient' => $consultation->patient,
    'currentConsultationId' => $consultation->id
])

@endsection
