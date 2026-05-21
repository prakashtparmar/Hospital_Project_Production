@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Patients</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Patients</h4>

    @can('patients.create')
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPatientModal">
        <i class="fa fa-plus"></i> Add Patient
    </button>
    @endcan
</div>


<div class="card">
    <div class="card-header"><strong>Patients Management</strong></div>

    <div class="card-body table-responsive">

        <table class="table table-bordered table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>Age</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Department</th>
                    <th width="150" class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($patients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>

                    <td>
                        <img src="{{ $patient->photo_path ? asset('storage/' . $patient->photo_path) : asset('ace/assets/images/avatars/profile-pic.jpg') }}"
                            style="width:45px;height:45px;border-radius:50%;object-fit:cover;">
                    </td>

                    <td>{{ $patient->patient_id }}</td>

                    <td>{{ $patient->full_name }}</td>

                    <td>{{ $patient->gender }}</td>

                    <td>{{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d M Y') : '---' }}</td>

                    <td>{{ $patient->age ?? '--' }}</td>

                    <td>{{ $patient->phone }}</td>

                    <td>
                        @if($patient->status)
                        <span class="label label-success">Active</span>
                        @else
                        <span class="label label-danger">Inactive</span>
                        @endif
                    </td>

                    <td>{{ $patient->department->name ?? '---' }}</td>

                    <td class="text-center">

                        <button class="btn btn-success btn-sm" data-toggle="modal"
                            data-target="#editPatientModal{{ $patient->id }}">
                            <i class="fa fa-pencil"></i>
                        </button>

                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Delete patient?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>


                {{-- ************************************************ --}}
                {{-- EDIT PATIENT MODAL --}}
                {{-- ************************************************ --}}
                <div class="modal fade" id="editPatientModal{{ $patient->id }}">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Patient – {{ $patient->full_name }}</h5>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                            </div>

                            <form action="{{ route('patients.update', $patient->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-md-4 mb-3">
                                            <label>First Name</label>
                                            <input type="text" name="first_name" class="form-control"
                                                value="{{ $patient->first_name }}" required>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Middle Name</label>
                                            <input type="text" name="middle_name" class="form-control"
                                                value="{{ $patient->middle_name }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Last Name</label>
                                            <input type="text" name="last_name" class="form-control"
                                                value="{{ $patient->last_name }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control"
                                                value="{{ $patient->phone }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ $patient->email }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="1" {{ $patient->status ? 'selected':'' }}>Active
                                                </option>
                                                <option value="0" {{ !$patient->status ? 'selected':'' }}>Inactive
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Gender</label>
                                            <select name="gender" class="form-control">
                                                <option {{ $patient->gender=='Male' ? 'selected':'' }}>Male</option>
                                                <option {{ $patient->gender=='Female' ? 'selected':'' }}>Female
                                                </option>
                                                <option {{ $patient->gender=='Other' ? 'selected':'' }}>Other</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Date of Birth</label>
                                            <input type="date" name="date_of_birth" class="form-control"
                                                value="{{ $patient->date_of_birth }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Age</label>
                                            <input type="number" name="age" class="form-control"
                                                value="{{ $patient->age }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Address</label>
                                            <textarea name="address" class="form-control"
                                                rows="2">{{ $patient->address }}</textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Department</label>
                                            <select name="department_id" class="form-control">
                                                <option value="">Select Department</option>
                                                @foreach($departments as $dept)
                                                <option value="{{ $dept->id }}"
                                                    {{ $patient->department_id == $dept->id ? 'selected':'' }}>
                                                    {{ $dept->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Emergency Contact Name</label>
                                            <input type="text" name="emergency_contact_name" class="form-control"
                                                value="{{ $patient->emergency_contact_name }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Emergency Contact Phone</label>
                                            <input type="text" name="emergency_contact_phone" class="form-control"
                                                value="{{ $patient->emergency_contact_phone }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Relation</label>
                                            <input type="text" name="emergency_contact_relation" class="form-control"
                                                value="{{ $patient->emergency_contact_relation }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Past Medical History</label>
                                            <textarea name="past_history" class="form-control"
                                                rows="3">{{ $patient->past_history }}</textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Family Details</label>
                                            <textarea name="family_details" class="form-control"
                                                rows="3">{{ $patient->family_details }}</textarea>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label>Photo</label>
                                            <input type="file" name="photo_path" class="form-control">
                                        </div>

                                        <div class="col-md-12 text-center">
                                            <label>QR Code</label><br>
                                            @if($patient->qr_code)
                                                <img src="{{ asset('storage/'.$patient->qr_code) }}"
                                                    width="180" height="180">
                                            @else
                                                <p>No QR Code Generated</p>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-primary"><i class="fa fa-save"></i> Update Patient</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                @endforeach
            </tbody>

        </table>

    </div>
</div>



{{-- ************************************************ --}}
{{-- ADD PATIENT MODAL --}}
{{-- ************************************************ --}}
<div class="modal fade" id="addPatientModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add New Patient</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <form action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Middle Name</label>
                            <input type="text" name="middle_name" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control">
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

                        <div class="col-md-6 mb-3">
                            <label>Past Medical History</label>
                            <textarea name="past_history" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Family Details</label>
                            <textarea name="family_details" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Photo</label>
                            <input type="file" name="photo_path" class="form-control">
                        </div>

                        <div class="col-md-12 text-center">
                            <label>QR Code</label><br>
                            <p class="text-muted">QR Code will be generated automatically after saving.</p>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Save Patient</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
