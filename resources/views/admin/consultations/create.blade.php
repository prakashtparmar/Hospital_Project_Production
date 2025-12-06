@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li><a href="{{ route('consultations.index') }}">Consultations</a></li>
        <li class="active">New Consultation</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h1><i class="fa fa-stethoscope"></i> New Consultation</h1>
</div>

<form method="POST" action="{{ route('consultations.store') }}">
    @csrf

    <input type="hidden" name="appointment_id" value="{{ optional($appointment)->id }}">

    {{-- AUTOMATICALLY SET STATUS = completed --}}
    <input type="hidden" name="status" value="completed">

    <div class="tabbable">
        <ul class="nav nav-tabs" id="myTab">

            <li class="active">
                <a data-toggle="tab" href="#basic">Basic Info</a>
            </li>

            <li><a data-toggle="tab" href="#clinical">Clinical Notes</a></li>

            <li><a data-toggle="tab" href="#vitals">Vitals</a></li>

            <li><a data-toggle="tab" href="#prescription">Prescription</a></li>

            <li><a data-toggle="tab" href="#history">History</a></li>

        </ul>

        <div class="tab-content">

            {{-- BASIC TAB --}}
            <div id="basic" class="tab-pane fade in active">

                <div class="row">

                    {{-- PATIENT --}}
                    <div class="col-sm-4">
                        <label>Patient <span class="text-danger">*</span></label>
                        <select name="patient_id" id="patientSelect"
                                class="form-control @error('patient_id') is-invalid @enderror">

                            <option value="">Select</option>

                            @foreach($patients as $p)
                                <option value="{{ $p->id }}"
                                    @if(old('patient_id', optional($appointment)->patient_id) == $p->id) selected @endif>
                                    {{ $p->patient_id }} - {{ $p->first_name }} {{ $p->last_name }}
                                </option>
                            @endforeach
                        </select>

                        @error('patient_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- DOCTOR --}}
                    <div class="col-sm-4">
                        <label>Doctor <span class="text-danger">*</span></label>
                        <select name="doctor_id"
                                class="form-control @error('doctor_id') is-invalid @enderror">

                            <option value="">Select</option>

                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}"
                                    @if(old('doctor_id', optional($appointment)->doctor_id) == $d->id) selected @endif>
                                    {{ $d->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('doctor_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- STATUS FIELD REMOVED --}}
                    {{-- System now forces status = completed --}}

                </div>
            </div>

            {{-- CLINICAL TAB --}}
            <div id="clinical" class="tab-pane fade">

                <div class="row">

                    <div class="col-sm-6">
                        <label>Chief Complaint</label>
                        <textarea name="chief_complaint"
                                  class="form-control">{{ old('chief_complaint') }}</textarea>

                        <label>History</label>
                        <textarea name="history"
                                  class="form-control @error('history') is-invalid @enderror">{{ old('history') }}</textarea>
                        @error('history')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        <label>Examination</label>
                        <textarea name="examination"
                                  class="form-control">{{ old('examination') }}</textarea>
                    </div>

                    <div class="col-sm-6">
                        <label>Provisional Diagnosis</label>
                        <textarea name="provisional_diagnosis"
                                  class="form-control">{{ old('provisional_diagnosis') }}</textarea>

                        <label>Final Diagnosis</label>
                        <textarea name="final_diagnosis"
                                  class="form-control">{{ old('final_diagnosis') }}</textarea>

                        <label>Plan / Advice</label>
                        <textarea name="plan"
                                  class="form-control">{{ old('plan') }}</textarea>
                    </div>

                </div>
            </div>

            {{-- VITALS TAB --}}
            <div id="vitals" class="tab-pane fade">

                <div class="row">

                    @foreach([
                        'bp' => 'BP',
                        'pulse' => 'Pulse',
                        'temperature' => 'Temperature',
                        'resp_rate' => 'Resp. Rate',
                        'spo2' => 'SpO2',
                        'weight' => 'Weight',
                        'height' => 'Height'
                    ] as $field => $label)

                    <div class="col-sm-3">
                        <label>{{ $label }}</label>

                        <input type="text" name="{{ $field }}"
                            value="{{ old($field) }}"
                            class="form-control @error($field) is-invalid @enderror">

                        @error($field)
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    @endforeach

                </div>

            </div>

            {{-- PRESCRIPTION TAB --}}
            <div id="prescription" class="tab-pane fade">

                <label>General Notes</label>
                <textarea name="prescription_notes"
                          class="form-control">{{ old('prescription_notes') }}</textarea>

                <br>

                <table class="table table-bordered" id="prescriptionTable">
                    <thead>
                        <tr>
                            <th>Drug</th>
                            <th>Strength</th>
                            <th>Dose</th>
                            <th>Route</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                            <th>Instructions</th>
                            <th width="40">
                                <button type="button" class="btn btn-success btn-xs" id="addRow">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            @foreach(['drug_name','strength','dose','route','frequency','duration','instructions'] as $f)
                                <td><input name="{{ $f }}[]" class="form-control"></td>
                            @endforeach

                            <td>
                                <button type="button" class="btn btn-danger btn-xs removeRow">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>

                </table>

            </div>

            {{-- HISTORY TAB --}}
            <div id="history" class="tab-pane fade">

                <div id="historyBox"
                     class="well well-sm"
                     style="max-height:350px; overflow-y:auto;">
                    <p class="text-muted">Select a patient to view history.</p>
                </div>

            </div>

        </div>
    </div>

    <div class="text-right">
        <button class="btn btn-primary">
            <i class="fa fa-save"></i> Save Consultation
        </button>
    </div>

</form>

@endsection

@push('scripts')
<script>
$(function(){

    $('#addRow').on('click', function(){
        $('#prescriptionTable tbody').append(`
            <tr>
                <td><input name="drug_name[]" class="form-control"></td>
                <td><input name="strength[]" class="form-control"></td>
                <td><input name="dose[]" class="form-control"></td>
                <td><input name="route[]" class="form-control"></td>
                <td><input name="frequency[]" class="form-control"></td>
                <td><input name="duration[]" class="form-control"></td>
                <td><input name="instructions[]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger btn-xs removeRow">
                        <i class="fa fa-trash"></i></button></td>
            </tr>
        `);
    });

    $(document).on('click','.removeRow',function(){
        if($('#prescriptionTable tbody tr').length > 1){
            $(this).closest('tr').remove();
        }
    });

    $('#patientSelect').change(function(){
        let id = $(this).val();

        if(!id){
            $('#historyBox').html('<p class="text-muted">Select a patient to view history.</p>');
            return;
        }

        $('#historyBox').html('<p class="text-muted">Loading...</p>');

        $.get("{{ url('consultations/patient') }}/" + id + "/history", function(res){
            $('#historyBox').html(res);
        });
    });

});
</script>
@endpush
