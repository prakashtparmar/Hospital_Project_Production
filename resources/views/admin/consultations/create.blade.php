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

<link rel="stylesheet" href="{{ asset('ace/assets/css/select2.min.css') }}">

<style>
    #prescriptionTable .medicine-select {
        width: 240px;
    }

    #prescriptionTable .select2-container {
        width: 100% !important;
    }

    #prescriptionTable .select2-selection--single {
        min-height: 34px;
        border-color: #d5d5d5;
        border-radius: 0;
    }

    #prescriptionTable .select2-selection__rendered {
        line-height: 32px;
    }

    #prescriptionTable .select2-selection__arrow {
        height: 32px;
    }

    /* Style for "Add new medicine" tag option */
    .select2-results__option--new-medicine {
        color: #27ae60;
        font-style: italic;
    }
</style>

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

                {{-- Helper tip for adding new medicines --}}
                <p class="text-muted" style="font-size:12px; margin-bottom:6px;">
                    <i class="fa fa-info-circle"></i>
                    If a medicine is not found in the list, type the name and press <kbd>Enter</kbd> to add it directly.
                </p>

                <table class="table table-bordered" id="prescriptionTable">
                    <thead>
                        <tr>
                            <th>Drug</th>
                            {{-- Strength column removed --}}
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
                            <td>
                                {{-- strength[] hidden keeps controller array-index alignment --}}
                                <input type="hidden" name="strength[]" value="">
                                <select name="drug_name[]" class="form-control medicine-select">
                                    <option value="">Search &amp; select medicine</option>
                                    @foreach($medicines as $medicine)
                                        <option value="{{ $medicine->name }}">
                                            {{ $medicine->name }}
                                            (Stock: {{ $medicine->current_stock }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <select name="dose[]" class="form-control">
                                    <option value=""></option>
                                    <option value="0.5 Tablet">0.5 Tablet</option>
                                    <option value="1 Tablet">1 Tablet</option>
                                    <option value="2 Tablets">2 Tablets</option>
                                    <option value="1 Capsule">1 Capsule</option>
                                    <option value="5 ml">5 ml</option>
                                    <option value="10 ml">10 ml</option>
                                    <option value="1 Drop">1 Drop</option>
                                    <option value="2 Drops">2 Drops</option>
                                    <option value="1 Puff">1 Puff</option>
                                </select>
                            </td>
                            <td>
                                <select name="route[]" class="form-control">
                                    <option value=""></option>
                                    <option value="Oral (PO)">Oral (PO)</option>
                                    <option value="Intravenous (IV)">Intravenous (IV)</option>
                                    <option value="Intramuscular (IM)">Intramuscular (IM)</option>
                                    <option value="Subcutaneous (SC)">Subcutaneous (SC)</option>
                                    <option value="Topical">Topical</option>
                                    <option value="Eye Drops">Eye Drops</option>
                                    <option value="Ear Drops">Ear Drops</option>
                                    <option value="Inhalation">Inhalation</option>
                                </select>
                            </td>
                            <td>
                                <select name="frequency[]" class="form-control">
                                    <option value=""></option>
                                    <option value="1-0-1">1-0-1</option>
                                    <option value="1-1-1">1-1-1</option>
                                    <option value="1-0-0">1-0-0</option>
                                    <option value="0-1-0">0-1-0</option>
                                    <option value="0-0-1">0-0-1</option>
                                    <option value="SOS (As needed)">SOS (As needed)</option>
                                </select>
                            </td>
                            <td>
                                <select name="duration[]" class="form-control">
                                    <option value=""></option>
                                    <option value="1 Day">1 Day</option>
                                    <option value="2 Days">2 Days</option>
                                    <option value="3 Days">3 Days</option>
                                    <option value="5 Days">5 Days</option>
                                    <option value="1 Week">1 Week</option>
                                    <option value="2 Weeks">2 Weeks</option>
                                    <option value="1 Month">1 Month</option>
                                    <option value="Ongoing">Ongoing</option>
                                </select>
                            </td>
                            <td>
                                <select name="instructions[]" class="form-control">
                                    <option value=""></option>
                                    <option value="Before Food">Before Food</option>
                                    <option value="After Food">After Food</option>
                                    <option value="With Food">With Food</option>
                                    <option value="Empty Stomach">Empty Stomach</option>
                                    <option value="At Bedtime">At Bedtime</option>
                                </select>
                            </td>

                            <td>
                                <button type="button" class="btn btn-danger btn-xs removeRow">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>

                </table>

                <template id="rowTemplate">
                    <tr>
                        <td>
                            <input type="hidden" name="strength[]" value="">
                            <select name="drug_name[]" class="form-control medicine-select">
                                <option value="">Search &amp; select medicine</option>
                                @foreach($medicines as $medicine)
                                    <option value="{{ $medicine->name }}">
                                        {{ $medicine->name }}
                                        (Stock: {{ $medicine->current_stock }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="dose[]" class="form-control">
                                <option value=""></option>
                                <option value="0.5 Tablet">0.5 Tablet</option>
                                <option value="1 Tablet">1 Tablet</option>
                                <option value="2 Tablets">2 Tablets</option>
                                <option value="1 Capsule">1 Capsule</option>
                                <option value="5 ml">5 ml</option>
                                <option value="10 ml">10 ml</option>
                                <option value="1 Drop">1 Drop</option>
                                <option value="2 Drops">2 Drops</option>
                                <option value="1 Puff">1 Puff</option>
                            </select>
                        </td>
                        <td>
                            <select name="route[]" class="form-control">
                                <option value=""></option>
                                <option value="Oral (PO)">Oral (PO)</option>
                                <option value="Intravenous (IV)">Intravenous (IV)</option>
                                <option value="Intramuscular (IM)">Intramuscular (IM)</option>
                                <option value="Subcutaneous (SC)">Subcutaneous (SC)</option>
                                <option value="Topical">Topical</option>
                                <option value="Eye Drops">Eye Drops</option>
                                <option value="Ear Drops">Ear Drops</option>
                                <option value="Inhalation">Inhalation</option>
                            </select>
                        </td>
                        <td>
                            <select name="frequency[]" class="form-control">
                                <option value=""></option>
                                <option value="1-0-1">1-0-1</option>
                                <option value="1-1-1">1-1-1</option>
                                <option value="1-0-0">1-0-0</option>
                                <option value="0-1-0">0-1-0</option>
                                <option value="0-0-1">0-0-1</option>
                                <option value="SOS (As needed)">SOS (As needed)</option>
                            </select>
                        </td>
                        <td>
                            <select name="duration[]" class="form-control">
                                <option value=""></option>
                                <option value="1 Day">1 Day</option>
                                <option value="2 Days">2 Days</option>
                                <option value="3 Days">3 Days</option>
                                <option value="5 Days">5 Days</option>
                                <option value="1 Week">1 Week</option>
                                <option value="2 Weeks">2 Weeks</option>
                                <option value="1 Month">1 Month</option>
                                <option value="Ongoing">Ongoing</option>
                            </select>
                        </td>
                        <td>
                            <select name="instructions[]" class="form-control">
                                <option value=""></option>
                                <option value="Before Food">Before Food</option>
                                <option value="After Food">After Food</option>
                                <option value="With Food">With Food</option>
                                <option value="Empty Stomach">Empty Stomach</option>
                                <option value="At Bedtime">At Bedtime</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-xs removeRow">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>

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
<script src="{{ asset('ace/assets/js/select2.min.js') }}"></script>

<script>
$(function(){

    /**
     * Initialize Select2 on medicine dropdowns.
     * tags: true  → allows the user to type a free-text name when the
     *               medicine is not found in the list and press Enter to add it.
     * createTag   → formats the new-entry label to make it obvious.
     * The submitted value is just the typed string, which the controller
     * already stores as drug_name (string). No backend changes needed.
     */
    function initMedicineSelect(selector){
        $(selector).select2({
            placeholder: 'Search & select medicine',
            allowClear: true,
            width: 'resolve',
            tags: true,
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') return null;
                return {
                    id:   term,
                    text: term + ' (Add new)',
                    newTag: true
                };
            },
            templateResult: function(data) {
                if (data.newTag) {
                    return $('<span style="color:#27ae60;font-style:italic;">' +
                             '<i class="fa fa-plus-circle"></i> ' + data.text +
                             '</span>');
                }
                return data.text;
            }
        });
    }

    initMedicineSelect('.medicine-select');

    $('#addRow').on('click', function(){
        $('#prescriptionTable tbody').append($('#rowTemplate').html());
        initMedicineSelect('#prescriptionTable tbody tr:last .medicine-select');
    });

    $(document).on('click', '.removeRow', function(){
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
