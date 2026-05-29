@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li><a href="{{ route('consultations.index') }}">Consultations</a></li>
        <li class="active">Edit Consultation</li>
    </ul>
</div>
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('ace/assets/css/select2.min.css') }}">

<style>
    #prescription-table .medicine-select {
        width: 240px;
    }

    #prescription-table .select2-container {
        width: 100% !important;
    }

    #prescription-table .select2-selection--single {
        min-height: 34px;
        border-color: #d5d5d5;
        border-radius: 0;
    }

    #prescription-table .select2-selection__rendered {
        line-height: 32px;
    }

    #prescription-table .select2-selection__arrow {
        height: 32px;
    }
</style>

<div class="page-header">
    <h1><i class="fa fa-pencil"></i> Edit Consultation #{{ $consultation->id }}</h1>
</div>

<form method="POST" action="{{ route('consultations.update',$consultation->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="tabbable">

        <ul class="nav nav-tabs">
            <li class="active"><a href="#basic" data-toggle="tab">Basic</a></li>
            <li><a href="#clinical" data-toggle="tab">Clinical</a></li>
            <li><a href="#vitals" data-toggle="tab">Vitals</a></li>
            <li><a href="#prescription" data-toggle="tab">Prescription</a></li>
            <li><a href="#documents" data-toggle="tab">Documents</a></li>
            <li><a href="#history" data-toggle="tab">History</a></li>
        </ul>

        <div class="tab-content">

            {{-- BASIC TAB --}}
            <div class="tab-pane fade in active" id="basic">
                <div class="row">

                    {{-- PATIENT --}}
                    <div class="col-sm-4">
                        <label>Patient <span class="text-danger">*</span></label>
                        <select name="patient_id" id="patientSelect"
                            class="form-control @error('patient_id') is-invalid @enderror">

                            @foreach($patients as $p)
                                <option value="{{ $p->id }}" @selected($consultation->patient_id==$p->id)>
                                    {{ $p->patient_id }} - {{ $p->first_name }} {{ $p->last_name }}
                                </option>
                            @endforeach

                        </select>
                        @error('patient_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- DOCTOR --}}
                    <div class="col-sm-4">
                        <label>Doctor <span class="text-danger">*</span></label>
                        <select name="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror">
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}" @selected($consultation->doctor_id==$d->id)>
                                    {{ $d->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- STATUS FIELD REMOVED --}}
                    {{-- System now forces status = completed --}}

                </div>
            </div>

            {{-- CLINICAL TAB --}}
            <div class="tab-pane fade" id="clinical">
                <div class="row">

                    <div class="col-sm-6">
                        <label>Chief Complaint</label>
                        <textarea name="chief_complaint" class="form-control">{{ $consultation->chief_complaint }}</textarea>

                        <label>History</label>
                        <textarea name="history" class="form-control">{{ $consultation->history }}</textarea>

                        <label>Examination</label>
                        <textarea name="examination" class="form-control">{{ $consultation->examination }}</textarea>
                    </div>

                    <div class="col-sm-6">
                        <label>Provisional Diagnosis</label>
                        <textarea name="provisional_diagnosis" class="form-control">{{ $consultation->provisional_diagnosis }}</textarea>

                        <label>Final Diagnosis</label>
                        <textarea name="final_diagnosis" class="form-control">{{ $consultation->final_diagnosis }}</textarea>

                        <label>Plan / Advice</label>
                        <textarea name="plan" class="form-control">{{ $consultation->plan }}</textarea>
                    </div>

                </div>
            </div>

            {{-- VITALS TAB --}}
            <div class="tab-pane fade" id="vitals">
                <div class="row">

                    @foreach([
                        'bp'=>'BP','pulse'=>'Pulse','temperature'=>'Temperature','resp_rate'=>'Resp Rate',
                        'spo2'=>'SpO2','weight'=>'Weight','height'=>'Height'
                    ] as $field => $label)

                        <div class="col-sm-3">
                            <label>{{ $label }}</label>
                            <input name="{{ $field }}" value="{{ $consultation->$field }}" class="form-control">
                        </div>

                    @endforeach

                </div>
            </div>

            {{-- PRESCRIPTION TAB --}}
            <div class="tab-pane fade" id="prescription">

                <label>General Notes</label>
                <textarea name="prescription_notes" class="form-control">{{ $consultation->prescriptions->first()->notes ?? '' }}</textarea>

                <br>

                <p class="text-muted" style="font-size:12px; margin-bottom:6px;">
                    <i class="fa fa-info-circle"></i>
                    If a medicine is not found in the list, type the name and press <kbd>Enter</kbd> to add it directly.
                </p>

                <table class="table table-bordered" id="prescription-table">
                    <thead>
                        <tr>
                            <th>Drug</th>
                            <th>Dose</th>
                            <th>Route</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                            <th>Instructions</th>
                            <th width="40">
                                <button type="button" class="btn btn-success btn-xs" id="btnAddRow">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($consultation->prescriptions->first()->items ?? [] as $item)
                            <tr>
                                <td>
                                    <input type="hidden" name="strength[]" value="{{ $item->strength }}">
                                    <select name="drug_name[]" class="form-control medicine-select" data-tags="true">
                                        <option value="">Search & select medicine</option>
                                        @foreach($medicines as $medicine)
                                            <option value="{{ $medicine->name }}" @if($item->drug_name == $medicine->name) selected @endif>
                                                {{ $medicine->name }} (Stock: {{ $medicine->current_stock }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="dose[]" class="form-control">
                                        <option value="{{ $item->dose }}" selected>{{ $item->dose }}</option>
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
                                        <option value="{{ $item->route }}" selected>{{ $item->route }}</option>
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
                                        <option value="{{ $item->frequency }}" selected>{{ $item->frequency }}</option>
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
                                        <option value="{{ $item->duration }}" selected>{{ $item->duration }}</option>
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
                                        <option value="{{ $item->instructions }}" selected>{{ $item->instructions }}</option>
                                        <option value="Before Food">Before Food</option>
                                        <option value="After Food">After Food</option>
                                        <option value="With Food">With Food</option>
                                        <option value="Empty Stomach">Empty Stomach</option>
                                        <option value="At Bedtime">At Bedtime</option>
                                    </select>
                                </td>
                                <td><button type="button" class="btn btn-danger btn-xs btnRemoveRow"><i class="fa fa-trash"></i></button></td>
                            </tr>
                        @empty
                            <tr>
                                <td>
                                    <select name="drug_name[]" class="form-control medicine-select">
                                        <option value="">Search & select medicine</option>
                                        @foreach($medicines as $medicine)
                                            <option value="{{ $medicine->name }}">
                                                {{ $medicine->name }}
                                                @if($medicine->strength)
                                                    - {{ $medicine->strength }}
                                                @endif
                                                (Stock: {{ $medicine->current_stock }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="strength[]" class="form-control">
                                        <option value=""></option>
                                        <option value="5mg">5mg</option>
                                        <option value="10mg">10mg</option>
                                        <option value="20mg">20mg</option>
                                        <option value="50mg">50mg</option>
                                        <option value="100mg">100mg</option>
                                        <option value="250mg">250mg</option>
                                        <option value="500mg">500mg</option>
                                        <option value="1g">1g</option>
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
                                <td><button type="button" class="btn btn-danger btn-xs btnRemoveRow"><i class="fa fa-trash"></i></button></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <template id="rowTemplate">
                    <tr>
                        <td>
                            <input type="hidden" name="strength[]" value="">
                            <select name="drug_name[]" class="form-control medicine-select">
                                <option value="">Search & select medicine</option>
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
                            <button type="button" class="btn btn-danger btn-xs btnRemoveRow">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>

            </div>

            {{-- DOCUMENTS TAB --}}
            <div class="tab-pane fade" id="documents">

                <h4>Uploaded Documents</h4>

                @if($consultation->documents->count())
                    <ul>
                        @foreach($consultation->documents as $doc)
                        <li style="margin-bottom:5px;">
                            <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank">{{ $doc->file_name }}</a>

                            <button type="button"
                                class="btn btn-danger btn-xs"
                                data-toggle="modal"
                                data-target="#deleteDocModal"
                                data-id="{{ $doc->id }}"
                                data-name="{{ $doc->file_name }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No documents uploaded.</p>
                @endif

                <hr>

                <label>Upload New Documents</label>
                <input type="file" name="documents[]" class="form-control" multiple>

            </div>

            {{-- HISTORY TAB --}}
            <div class="tab-pane fade" id="history">
                <div id="historyBox" class="well well-sm" style="max-height:350px; overflow-y:auto;">
                    @include('admin.consultations.partials.history', ['history' => $history, 'patient' => $consultation->patient])
                </div>
            </div>

        </div>

    </div>

    <div class="text-right">
        <button class="btn btn-primary"><i class="fa fa-save"></i> Update Consultation</button>
    </div>

</form>


{{-- DELETE DOCUMENT MODAL --}}
<div class="modal fade" id="deleteDocModal" tabindex="-1">
    <div class="modal-dialog modal-sm">

        <form method="POST" id="deleteDocForm">
            @csrf
            @method('DELETE')

            <div class="modal-content">

                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white">Delete Document</h4>
                </div>

                <div class="modal-body">
                    <p>Are you sure you want to delete:</p>
                    <p><strong id="docName"></strong></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>


@endsection

@push('scripts')
<script src="{{ asset('ace/assets/js/select2.min.js') }}"></script>
<script>
$(function(){


    function initMedicineSelect(selector){
        $(selector).select2({
            placeholder: 'Search & select medicine',
            allowClear: true,
            width: 'resolve',
            tags: true,
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') return null;
                return { id: term, text: term + ' (Add new)', newTag: true };
            },
            templateResult: function(data) {
                if (data.newTag) {
                    return $('<span style="color:#27ae60;font-style:italic;"><i class="fa fa-plus-circle"></i> ' + data.text + '</span>');
                }
                return data.text;
            }
        });
    }

    initMedicineSelect('.medicine-select');

    // ADD ROW
    $('#btnAddRow').on('click', function(){
        $('#prescription-table tbody').append($('#rowTemplate').html());
        initMedicineSelect('#prescription-table tbody tr:last .medicine-select');
    });

    // REMOVE ROW
    $(document).on('click', '.btnRemoveRow', function(){
        if($('#prescription-table tbody tr').length > 1){
            $(this).closest('tr').remove();
        }
    });

    // LOAD HISTORY
    $('#patientSelect').change(function(){
        let id = $(this).val();
        $('#historyBox').html('<p class="text-muted">Loading...</p>');
        $.get("/consultations/patient/" + id + "/history", function(res){
            $('#historyBox').html(res);
        });
    });

    // DELETE DOCUMENT MODAL FILLER
    $('#deleteDocModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var docId = button.data('id');
        var docName = button.data('name');

        $('#docName').text(docName);

        var actionUrl = "/consultations/documents/" + docId;
        $('#deleteDocForm').attr('action', actionUrl);
    });

});
</script>
@endpush
