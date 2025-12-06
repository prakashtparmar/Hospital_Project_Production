@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('appointments.index') }}">Appointments</a>
        </li>
        <li class="active">Create Appointment</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Create Appointment</h4>

    <a href="{{ route('appointments.index') }}" class="btn btn-default btn-sm">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade in">
    <button class="close" data-dismiss="alert">×</button>
    <i class="fa fa-check"></i> {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade in">
    <button class="close">×</button>
    <strong>Whoops!</strong>
    <ul>
        @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
        @endforeach
    </ul>
</div>
@endif


<div class="card">
    <div class="card-header"><strong>Appointment Management</strong></div>
    <div class="card-body">

        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf

            <div class="row">

                {{-- LEFT COLUMN --}}
                <div class="col-md-6">

                    {{-- Patient Select --}}
                    <div class="form-group">
                        <label><strong>Patient *</strong></label>

                        <div class="input-group">
                            <select name="patient_id" id="patientSelect" class="form-control select2">
                                <option value="">Select Patient...</option>

                                @foreach ($patients as $p)
                                <option value="{{ $p->id }}"
                                    {{ isset($selectedPatient) && $selectedPatient == $p->id ? 'selected' : '' }}>
                                    {{ $p->patient_id }} - {{ $p->first_name }} {{ $p->last_name }}
                                </option>
                                @endforeach
                            </select>

                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPatientModal">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Specialty --}}
                    <div class="form-group">
                        <label><strong>Specialty *</strong></label>
                        <select id="specialtySelect" class="form-control select2">
                            <option value="">Select Specialty...</option>
                            <option value="__ALL__">All</option>
                            @foreach(
                                $doctors->map(fn($d)=>optional($d->doctorProfile)->specialization)
                                    ->filter()->unique() as $sp)
                                <option value="{{ $sp }}">{{ $sp }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Doctor --}}
                    <div class="form-group">
                        <label><strong>Doctor *</strong></label>
                        <select name="doctor_id" id="doctorSelect" class="form-control select2">
                            <option value="">Select Doctor...</option>
                            @foreach ($doctors as $d)
                            <option value="{{ $d->id }}"
                                data-specialty="{{ optional($d->doctorProfile)->specialization }}"
                                data-department="{{ optional($d->doctorProfile)->department_id }}">
                                {{ $d->name }}
                                @if(optional($d->doctorProfile)->specialization)
                                    — {{ optional($d->doctorProfile)->specialization }}
                                @endif
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Department --}}
                    <div class="form-group">
                        <label><strong>Department *</strong></label>
                        <select name="department_id" id="departmentSelect" class="form-control select2">
                            <option value="">Select Department...</option>
                            @foreach ($departments as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date --}}
                    <div class="form-group">
                        <label><strong>Appointment Date *</strong></label>
                        <input type="date" name="appointment_date" class="form-control"
                            value="{{ date('Y-m-d') }}">
                    </div>

                    {{-- Time --}}
                    <div class="form-group">
                        <label><strong>Time Slot *</strong></label>
                        <select name="appointment_time" id="appointment_time" class="form-control">
                            <option value="">-- Select Time Slot --</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label><strong>Status *</strong></label>
                        <select name="status" class="form-control select2">
                            @foreach(['Pending','CheckedIn','InConsultation','Completed','Cancelled'] as $s)
                                <option>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                {{-- RIGHT COLUMN --}}
                <div class="col-md-6">

                    <div class="form-group">
                        <label><strong>Visit Type</strong></label>
                        <select name="visit_type" class="form-control select2">
                            <option value="OPD">OPD</option>
                            <option value="IPD">IPD</option>
                            <option value="Emergency">Emergency</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><strong>Appointment Type</strong></label>
                        <select name="appointment_type" class="form-control select2">
                            <option value="Walk-In">Walk-In</option>
                            <option value="Telephonic">Telephonic</option>
                            <option value="Referral">Referral</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><strong>Chief Complaint</strong></label>
                        <textarea name="chief_complaint" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label><strong>Referral</strong></label>
                        <input type="text" name="referral" class="form-control">
                    </div>

                    <div class="form-group">
                        <label><strong>Priority</strong></label>
                        <select name="priority" class="form-control select2">
                            <option>Normal</option>
                            <option>High</option>
                            <option>Emergency</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><strong>Notes</strong></label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>

                </div>
            </div>

            <hr>

            <div class="text-center">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fa fa-check"></i> Create Appointment
                </button>
            </div>

        </form>
    </div>
</div>


{{-- ************************************************ --}}
{{-- ADD PATIENT MODAL WITH ALL MISSING FIELDS --}}
{{-- ************************************************ --}}
<div class="modal fade" id="addPatientModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add New Patient</h5>
                <button class="close" data-dismiss="modal">×</button>
            </div>

            <form action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="from_appointment" value="1">

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label>First Name *</label>
                            <input name="first_name" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Middle Name</label>
                            <input name="middle_name" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Last Name</label>
                            <input name="last_name" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Phone</label>
                            <input name="phone" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Gender</label>
                            <select name="gender" class="form-control">
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Age</label>
                            <input type="number" name="age" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Department</label>
                            <select name="department_id" class="form-control">
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Emergency Contact --}}
                        <div class="col-md-4 mb-3">
                            <label>Emergency Contact Name</label>
                            <input type="text" name="emergency_contact_name" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Emergency Contact Phone</label>
                            <input type="text" name="emergency_contact_phone" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Relation</label>
                            <input type="text" name="emergency_contact_relation" class="form-control">
                        </div>

                        {{-- Medical Info --}}
                        <div class="col-md-6 mb-3">
                            <label>Past Medical History</label>
                            <textarea name="past_history" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Family Details</label>
                            <textarea name="family_details" class="form-control" rows="3"></textarea>
                        </div>

                        {{-- Photo --}}
                        <div class="col-md-12 mb-3">
                            <label>Photo</label>
                            <input type="file" name="photo_path" class="form-control">
                        </div>

                        {{-- QR Code Info --}}
                        <div class="col-md-12 text-center">
                            <p class="text-muted">QR Code will be generated after saving</p>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Save Patient</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection


