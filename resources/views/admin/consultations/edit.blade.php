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

                    {{-- STATUS --}}
                    <div class="col-sm-4">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" id="statusSelect" class="form-control @error('status') is-invalid @enderror">
                            @foreach(['in_progress', 'completed', 'cancelled'] as $st)
                                <option value="{{ $st }}" @selected($consultation->status==$st)>
                                    {{ ucfirst(str_replace('_',' ',$st)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

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

                <table class="table table-bordered" id="prescription-table">
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
                                <button type="button" class="btn btn-success btn-xs" id="btnAddRow">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($consultation->prescriptions->first()->items ?? [] as $item)
                            <tr>
                                <td><input name="drug_name[]" class="form-control" value="{{ $item->drug_name }}"></td>
                                <td><input name="strength[]" class="form-control" value="{{ $item->strength }}"></td>
                                <td><input name="dose[]" class="form-control" value="{{ $item->dose }}"></td>
                                <td><input name="route[]" class="form-control" value="{{ $item->route }}"></td>
                                <td><input name="frequency[]" class="form-control" value="{{ $item->frequency }}"></td>
                                <td><input name="duration[]" class="form-control" value="{{ $item->duration }}"></td>
                                <td><input name="instructions[]" class="form-control" value="{{ $item->instructions }}"></td>
                                <td><button type="button" class="btn btn-danger btn-xs btnRemoveRow"><i class="fa fa-trash"></i></button></td>
                            </tr>
                        @empty
                            <tr>
                                @foreach(['drug_name','strength','dose','route','frequency','duration','instructions'] as $f)
                                    <td><input name="{{ $f }}[]" class="form-control"></td>
                                @endforeach
                                <td><button type="button" class="btn btn-danger btn-xs btnRemoveRow"><i class="fa fa-trash"></i></button></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

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
<script>
$(function(){

    // ADD ROW
    $('#btnAddRow').on('click', function(){
        $('#prescription-table tbody').append(`
            <tr>
                <td><input name="drug_name[]" class="form-control"></td>
                <td><input name="strength[]" class="form-control"></td>
                <td><input name="dose[]" class="form-control"></td>
                <td><input name="route[]" class="form-control"></td>
                <td><input name="frequency[]" class="form-control"></td>
                <td><input name="duration[]" class="form-control"></td>
                <td><input name="instructions[]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger btn-xs btnRemoveRow"><i class="fa fa-trash"></i></button></td>
            </tr>
        `);
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
