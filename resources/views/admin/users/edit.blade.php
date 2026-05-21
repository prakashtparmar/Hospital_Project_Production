@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li><a href="{{ route('users.index') }}">Users</a></li>
        <li class="active">Edit User</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h1>
        User Management
        <small><i class="ace-icon fa fa-angle-double-right"></i> Edit User</small>

        <a class="btn btn-primary btn-sm pull-right" href="{{ route('users.index') }}">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </h1>
</div>

<div class="row">

    {{-- LEFT PROFILE IMAGE --}}
    <div class="col-sm-3 center">
        <span class="profile-picture">
            <img class="editable img-responsive"
                 alt="User Image"
                 src="{{ $user->image ? asset('storage/' . $user->image) : asset('ace/assets/images/avatars/profile-pic.jpg') }}">
        </span>
        <div class="space-4"></div>
    </div>

    {{-- RIGHT FORM WITH ACE TABS --}}
    <div class="col-sm-9">

        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
            @csrf
            @method('PUT')

            <div class="tabbable">

                <ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
                    <li class="active"><a data-toggle="tab" href="#basic-info">Basic Info</a></li>
                    <li><a data-toggle="tab" href="#roles-tab">Roles</a></li>
                    <li><a data-toggle="tab" href="#profile-tab">Profile</a></li>
                    <li><a data-toggle="tab" href="#personal-tab">Personal Info</a></li>
                </ul>

                <div class="tab-content">

                    {{-- BASIC INFO TAB --}}
                    <div id="basic-info" class="tab-pane active">
                        <h4 class="header blue bolder smaller">Basic Information</h4>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" class="form-control"
                                       value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control"
                                       value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">New Password</label>
                            <div class="col-sm-9">
                                <input type="password" name="password" class="form-control">
                                <small class="text-muted">Leave blank to keep existing password.</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mobile</label>
                            <div class="col-sm-9">
                                <input type="text" name="mobile" class="form-control"
                                       value="{{ old('mobile', $user->mobile) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Active</label>
                            <div class="col-sm-9">
                                <select name="is_active" class="form-control">
                                    <option value="1" {{ $user->is_active ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ !$user->is_active ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    {{-- ROLES TAB --}}
                    <div id="roles-tab" class="tab-pane">
                        <h4 class="header blue bolder smaller">Assign Roles</h4>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Roles</label>
                            <div class="col-sm-9">
                                @foreach ($roles as $role)
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="roles[]"
                                               value="{{ $role->name }}"
                                            {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                        {{ $role->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    {{-- PROFILE TAB --}}
                    <div id="profile-tab" class="tab-pane">
                        <h4 class="header blue bolder smaller">Profile Details</h4>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">User Type</label>
                            <div class="col-sm-9">
                                <select name="user_type" class="form-control">
                                    <option value="">Select</option>
                                    @foreach (['Admin','Doctor','Nurse','Receptionist','Pharmacist','Lab Technician','Patient','Accountant','Other'] as $type)
                                        <option value="{{ $type }}" {{ $user->user_type == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">User Code</label>
                            <div class="col-sm-9">
                                <input type="text" name="user_code" class="form-control"
                                       value="{{ old('user_code', $user->user_code) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Profile Image</label>
                            <div class="col-sm-9">
                                <input type="file" name="image" class="form-control">
                                <small class="text-muted">Upload to replace existing image.</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-9">
                                <textarea name="address" class="form-control" rows="2">{{ old('address', $user->address) }}</textarea>
                            </div>
                        </div>

                    </div>

                    {{-- PERSONAL INFO TAB --}}
                    <div id="personal-tab" class="tab-pane">
                        <h4 class="header blue bolder smaller">Personal Information</h4>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Gender</label>
                            <div class="col-sm-9">
                                <select name="gender" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Marital Status</label>
                            <div class="col-sm-9">
                                <select name="marital_status" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Single" {{ $user->marital_status == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ $user->marital_status == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Other" {{ $user->marital_status == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date of Birth</label>
                            <div class="col-sm-9">
                                <input type="date" name="date_of_birth" class="form-control"
                                       value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Joining Date</label>
                            <div class="col-sm-9">
                                <input type="date" name="joining_date" class="form-control"
                                       value="{{ old('joining_date', optional($user->joining_date)->format('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Emergency Contact</label>
                            <div class="col-sm-9">
                                <input type="text" name="emergency_contact_no" class="form-control"
                                       value="{{ old('emergency_contact_no', $user->emergency_contact_no) }}">
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-info btn-sm">
                        <i class="fa fa-save"></i> Update User
                    </button>
                </div>
            </div>

        </form>

    </div>
</div>

@endsection
