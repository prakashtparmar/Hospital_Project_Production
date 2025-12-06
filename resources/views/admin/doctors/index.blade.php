@extends('layouts.app')

@section('breadcrumbs')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li><i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="active">Doctors</li>
        </ul>
    </div>
@endsection

@section('content')

    <div class="page-header d-flex justify-content-between align-items-center mb-3">
        <h4 class="page-title">Doctors</h4>

        @can('doctors.create')
            {{-- MODAL BUTTON (Option 1) --}}
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addDoctorModal">
                <i class="fa fa-plus"></i> Add Doctor
            </button>
        @endcan
    </div>


    <div class="card">
        <div class="card-header"><strong>Doctor Profiles</strong></div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>Doctor Name</th>
                        <th>Department</th>
                        <th>Specialization</th>
                        <th>Qualification</th>
                        <th>Reg. No</th>
                        <th>Fee</th>
                        <th>Biography</th>
                        <th>Schedule</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($doctors as $doc)

                        @php
                            $profile = $doc->doctorProfile;
                            $schedules = \App\Models\DoctorSchedule::where('doctor_id', $doc->id)
                                ->orderByRaw("FIELD(day,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
                                ->get();

                            $weekDays = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                        @endphp

                        <tr>
                            <td>{{ $profile->id ?? '—' }}</td>

                            <td>
                                {{ $doc->name }} <br>
                                <small class="text-muted">({{ $doc->email }})</small>
                            </td>

                            <td>{{ $profile->department->name ?? 'N/A' }}</td>

                            <td>{{ $profile->specialization ?? '—' }}</td>

                            <td>{{ $profile->qualification ?? '—' }}</td>

                            <td>{{ $profile->registration_no ?? '—' }}</td>

                            <td>₹{{ number_format($profile->consultation_fee ?? 0, 2) }}</td>

                            <td>{{ isset($profile->biography) ? Str::limit($profile->biography, 40) : '—' }}</td>

                            {{-- ---------- SCHEDULE COLUMN ---------- --}}
                            <td>

                                {{-- IF SCHEDULE EXISTS --}}
                                @if($schedules->count())

                                    {{-- VIEW BUTTON --}}
                                    <button class="btn btn-info btn-sm"
                                            data-toggle="modal"
                                            data-target="#scheduleModal{{ $doc->id }}">
                                        View
                                    </button>

                                    {{-- FULL EXISTING SCHEDULE VIEW/EDIT/DELETE MODALS (WILL BE IN PART 2) --}}

                                @else

                                    {{-- NO SCHEDULE --}}
                                    <span class="label label-default"
                                          style="cursor:pointer;"
                                          data-toggle="modal"
                                          data-target="#createSingleScheduleModal{{ $doc->id }}">
                                        No Schedule
                                    </span>

                                    {{-- SINGLE SCHEDULE ADD MODAL (WILL BE IN PART 2) --}}

                                @endif
                            </td>

                            {{-- ACTIONS --}}
                            <td class="text-center">

                                @if(!$profile)
                                    <a href="{{ route('doctors.create') }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-plus"></i> Create Profile
                                    </a>
                                @else

                                    {{-- VIEW PAGE (unchanged) --}}
                                    <a href="{{ route('doctors.edit', $doc->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    {{-- EDIT BUTTON NOW SHOWS MODAL (Option A) --}}
                                    <button class="btn btn-success btn-sm"
                                            data-toggle="modal"
                                            data-target="#editDoctorModal{{ $doc->id }}">
                                        <i class="fa fa-pencil"></i>
                                    </button>

                                    {{-- DELETE --}}
                                    <form action="{{ route('doctors.destroy', $doc->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete this doctor profile?');">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>

                                @endif

                            </td>
                        </tr>

                    @endforeach
                </tbody>

            </table>
        </div>

        <div class="card-footer">
            {{ $doctors->links() }}
        </div>
    </div>

        {{-- ############################################################ --}}
    {{-- ######################  ALL MODALS START  ################### --}}
    {{-- ############################################################ --}}

    @foreach ($doctors as $doc)
        @php
            $profile = $doc->doctorProfile;
            $schedules = \App\Models\DoctorSchedule::where('doctor_id', $doc->id)
                ->orderByRaw("FIELD(day,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
                ->get();

            $weekDays = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        @endphp


        {{-- ======================================================= --}}
        {{-- =============== EXISTING SCHEDULE VIEW MODAL =========== --}}
        {{-- ======================================================= --}}
        @if($schedules->count())
            <div class="modal fade" id="scheduleModal{{ $doc->id }}">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Doctor Schedule – {{ $doc->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>

                        <div class="modal-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Slot</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach ($schedules as $sch)
                                    <tr>
                                        <td>{{ $sch->day }}</td>
                                        <td>{{ date('h:i A', strtotime($sch->start_time)) }}</td>
                                        <td>{{ date('h:i A', strtotime($sch->end_time)) }}</td>
                                        <td>{{ $sch->slot_duration }} mins</td>
                                        <td>
                                            <span class="badge {{ $sch->status ? 'bg-success':'bg-danger' }}">
                                                {{ $sch->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>

                                        <td>
                                            <button class="btn btn-warning btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#editScheduleModal{{ $sch->id }}">
                                                Edit
                                            </button>
                                        </td>

                                        <td>
                                            <form method="POST"
                                                  action="{{ route('doctor-schedule.destroy', $sch->id) }}"
                                                  onsubmit="return confirm('Delete schedule?')">
                                                @csrf @method('DELETE')
                                                <input type="hidden" name="redirect_back" value="1">
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>


                                    {{-- ========================= --}}
                                    {{-- EDIT SCHEDULE MODAL       --}}
                                    {{-- ========================= --}}
                                    <div class="modal fade" id="editScheduleModal{{ $sch->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Schedule – {{ $doc->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                                </div>

                                                <form action="{{ route('doctor-schedule.update', $sch->id) }}" method="POST">
                                                    @csrf @method('PUT')

                                                    <input type="hidden" name="doctor_id" value="{{ $doc->id }}">
                                                    <input type="hidden" name="redirect_back" value="1">

                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label>Day</label>
                                                            <select name="day" class="form-control">
                                                                @foreach($weekDays as $d)
                                                                    <option value="{{ $d }}" {{ $d == $sch->day ? 'selected':'' }}>
                                                                        {{ $d }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Start Time</label>
                                                            <input type="time" name="start_time"
                                                                   class="form-control"
                                                                   value="{{ $sch->start_time }}" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>End Time</label>
                                                            <input type="time" name="end_time"
                                                                   class="form-control"
                                                                   value="{{ $sch->end_time }}" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Slot Duration</label>
                                                            <input type="number" min="5" step="5"
                                                                   name="slot_duration"
                                                                   value="{{ $sch->slot_duration }}"
                                                                   class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <select name="status" class="form-control">
                                                                <option value="1" {{ $sch->status ? 'selected':'' }}>Active</option>
                                                                <option value="0" {{ !$sch->status ? 'selected':'' }}>Inactive</option>
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary">Update</button>
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

                        <div class="modal-footer">
                            <button class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#addSingleScheduleModal{{ $doc->id }}">
                                <i class="fa fa-plus"></i> Add Schedule
                            </button>

                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>


            {{-- ======================================================= --}}
            {{-- ADD SINGLE SCHEDULE MODAL (WHEN SCHEDULE EXISTS) --}}
            {{-- ======================================================= --}}
            <div class="modal fade" id="addSingleScheduleModal{{ $doc->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Add Schedule – {{ $doc->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>

                        <form action="{{ route('doctor-schedule.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="doctor_id" value="{{ $doc->id }}">
                            <input type="hidden" name="redirect_back" value="1">

                            <div class="modal-body">

                                <div class="form-group">
                                    <label>Day</label>
                                    <select name="day" class="form-control" required>
                                        <option value="">Select</option>
                                        @foreach($weekDays as $day)
                                            <option value="{{ $day }}">{{ $day }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Start Time</label>
                                    <input type="time" name="start_time" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>End Time</label>
                                    <input type="time" name="end_time" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Slot Duration</label>
                                    <input type="number" min="5" step="5"
                                           name="slot_duration" value="15"
                                           class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        @else

            {{-- ======================================================= --}}
            {{-- NO SCHEDULE → CREATE SINGLE SCHEDULE MODAL             --}}
            {{-- ======================================================= --}}
            <div class="modal fade" id="createSingleScheduleModal{{ $doc->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Add Schedule – {{ $doc->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>

                        <form action="{{ route('doctor-schedule.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="redirect_back" value="1">
                            <input type="hidden" name="doctor_id" value="{{ $doc->id }}">

                            <div class="modal-body">

                                <div class="form-group">
                                    <label>Day</label>
                                    <select name="day" class="form-control" required>
                                        <option value="">Select</option>
                                        @foreach($weekDays as $day)
                                            <option value="{{ $day }}">{{ $day }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Start Time</label>
                                    <input type="time" name="start_time" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>End Time</label>
                                    <input type="time" name="end_time" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Slot Duration</label>
                                    <input type="number" min="5" step="5"
                                           name="slot_duration" value="15"
                                           class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save
                                </button>
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">Cancel</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        @endif



        {{-- ======================================================= --}}
        {{-- ===============   EDIT DOCTOR MODAL (NEW) ============== --}}
        {{-- ======================================================= --}}
        <div class="modal fade" id="editDoctorModal{{ $doc->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Doctor Profile</h5>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <form action="{{ route('doctors.update', $doc->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-body">
                            <div class="row">

                                {{-- USER (DISABLED — Option 1 confirmed) --}}
                                <div class="col-md-6 mb-3">
                                    <label><strong>User</strong></label>
                                    <select class="form-control" disabled>
                                        <option>{{ $doc->name }} ({{ $doc->email }})</option>
                                    </select>

                                    {{-- Maintain original user_id --}}
                                    <input type="hidden" name="user_id" value="{{ $doc->id }}">
                                </div>

                                {{-- DEPARTMENT --}}
                                <div class="col-md-6 mb-3">
                                    <label><strong>Department</strong></label>
                                    <select name="department_id" class="form-control">
                                        <option value="">-- Select Department --</option>
                                        @foreach ($departments as $d)
                                            <option value="{{ $d->id }}"
                                                {{ $profile->department_id == $d->id ? 'selected' : '' }}>
                                                {{ $d->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- SPECIALIZATION --}}
                                <div class="col-md-6 mb-3">
                                    <label><strong>Specialization</strong></label>
                                    <input type="text" name="specialization"
                                           class="form-control"
                                           value="{{ $profile->specialization }}">
                                </div>

                                {{-- QUALIFICATION --}}
                                <div class="col-md-6 mb-3">
                                    <label><strong>Qualification</strong></label>
                                    <input type="text" name="qualification"
                                           class="form-control"
                                           value="{{ $profile->qualification }}">
                                </div>

                                {{-- REGISTRATION NO --}}
                                <div class="col-md-6 mb-3">
                                    <label><strong>Registration Number</strong></label>
                                    <input type="text" name="registration_no"
                                           class="form-control"
                                           value="{{ $profile->registration_no }}">
                                </div>

                                {{-- FEE --}}
                                <div class="col-md-6 mb-3">
                                    <label><strong>Consultation Fee (₹)</strong></label>
                                    <input type="number" step="0.01"
                                           name="consultation_fee"
                                           class="form-control"
                                           value="{{ $profile->consultation_fee }}">
                                </div>

                                {{-- BIOGRAPHY --}}
                                <div class="col-md-12 mb-3">
                                    <label><strong>Biography</strong></label>
                                    <textarea name="biography" rows="4"
                                              class="form-control">{{ $profile->biography }}</textarea>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Doctor
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    @endforeach



    {{-- ======================================================= --}}
    {{-- ===============  ADD DOCTOR MODAL (EXISTING) ============ --}}
    {{-- ======================================================= --}}
    <div class="modal fade" id="addDoctorModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Doctor Profile</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <form action="{{ route('doctors.store') }}" method="POST">
                    @csrf

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label><strong>Select User</strong></label>
                                <select name="user_id" class="form-control" required>
                                    <option value="">-- Select User --</option>
                                    @foreach ($users as $u)
                                        <option value="{{ $u->id }}">
                                            {{ $u->name }} ({{ $u->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Department</strong></label>
                                <select name="department_id" class="form-control">
                                    <option value="">-- Select Department --</option>
                                    @foreach ($departments as $d)
                                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Specialization</strong></label>
                                <input type="text" name="specialization" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Qualification</strong></label>
                                <input type="text" name="qualification" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Registration Number</strong></label>
                                <input type="text" name="registration_no" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Consultation Fee (₹)</strong></label>
                                <input type="number" step="0.01" name="consultation_fee" class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label><strong>Biography</strong></label>
                                <textarea name="biography" rows="4" class="form-control"></textarea>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">
                            <i class="fa fa-save"></i> Save Doctor Profile
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection
