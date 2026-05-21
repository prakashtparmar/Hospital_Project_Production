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
        <li class="active">Admit Patient</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h1>
        Admit Patient
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Add New IPD Admission
        </small>
    </h1>
</div>

<div class="row">
    <div class="col-xs-12">

        <form action="{{ route('ipd.store') }}" method="POST" class="form-horizontal">
            @csrf

            {{-- PATIENT + DOCTOR --}}
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Patient & Doctor Details</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main">

                        <div class="row">

                            {{-- Patient --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Patient</label>
                                    <select name="patient_id" class="form-control">
                                        @foreach($patients as $p)
                                            <option value="{{ $p->id }}">
                                                {{ $p->patient_id }} - {{ $p->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Doctor --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Doctor</label>
                                    <select name="doctor_id" id="doctorSelect" class="form-control">
                                        <option value="">-- Select Doctor --</option>
                                        @foreach($doctors as $d)
                                            <option 
                                                value="{{ $d->id }}"
                                                data-department="{{ $d->doctorProfile->department_id ?? '' }}"
                                            >
                                                {{ $d->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Department --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select name="department_id" id="departmentSelect" class="form-control">
                                        <option value="">-- Select Department --</option>
                                        @foreach($departments as $dep)
                                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            {{-- WARD ROOM BED --}}
            <div class="widget-box mt-3">
                <div class="widget-header">
                    <h4 class="widget-title">Ward, Room & Bed Details</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">

                            {{-- Ward --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Ward</label>
                                    <select name="ward_id" id="wardSelect" class="form-control">
                                        <option value="">-- Select Ward --</option>
                                        @foreach($wards as $w)
                                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Room --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Room</label>
                                    <select name="room_id" id="roomSelect" class="form-control">
                                        <option value="">-- Select Room --</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Bed --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bed</label>
                                    <select name="bed_id" id="bedSelect" class="form-control">
                                        <option value="">-- Select Bed --</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            {{-- ADMISSION INFO --}}
            <div class="widget-box mt-3">
                <div class="widget-header">
                    <h4 class="widget-title">Admission Information</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main">

                        <div class="row">
                            <div class="col-md-6">
                                <label>Admission Date & Time</label>
                                <input type="datetime-local" name="admission_date" id="admissionDateTime" class="form-control">
                            </div>
                        </div>

                        <label class="mt-2">Reason for Admission</label>
                        <textarea name="admission_reason" class="form-control" rows="3"></textarea>

                        <label class="mt-2">Initial Diagnosis</label>
                        <textarea name="initial_diagnosis" class="form-control" rows="3"></textarea>

                    </div>
                </div>
            </div>

            {{-- SUBMIT --}}
            <div class="text-right mt-3">
                <button class="btn btn-success btn-sm">
                    <i class="ace-icon fa fa-check"></i> Admit Patient
                </button>
                <a href="{{ route('ipd.index') }}" class="btn btn-default btn-sm">
                    <i class="ace-icon fa fa-arrow-left"></i> Back
                </a>
            </div>

        </form>

    </div>
</div>

@endsection

<!-- @push('scripts')
<script>
// Auto-set current date & time
document.addEventListener("DOMContentLoaded", function() {
    let now = new Date();
    let formatted = now.toISOString().slice(0, 16); // YYYY-MM-DDTHH:MM
    document.getElementById("admissionDateTime").value = formatted;
});

// Auto-select department when doctor changes
$(document).ready(function () {
    $('#doctorSelect').on('change', function () {
        let dept = $(this).find(':selected').data('department');
        $('#departmentSelect').val(dept ? dept : "");
    });
});
</script>
@endpush -->
