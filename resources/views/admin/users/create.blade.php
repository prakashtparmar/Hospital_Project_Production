@extends('layouts.app')

@section('breadcrumbs')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li><a href="{{ route('users.index') }}">Users</a></li>
            <li class="active">Create User</li>
        </ul>
    </div>
@endsection

@section('content')

    <div class="page-header">
        <h1>
            User Management
            <small><i class="ace-icon fa fa-angle-double-right"></i> Create User</small>

            <a class="btn btn-primary btn-sm pull-right" href="{{ route('users.index') }}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </h1>
    </div>

    <div class="row">

        {{-- LEFT PROFILE IMAGE --}}
        <div class="col-sm-3 center">
            <span class="profile-picture">
                <img class="editable img-responsive" alt="User Image"
                     src="{{ asset('ace/assets/images/avatars/profile-pic.jpg') }}">
            </span>
            <div class="space-4"></div>
        </div>

        {{-- RIGHT FORM WITH ACE TABS --}}
        <div class="col-sm-9">

            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                @csrf

                <div class="tabbable">

                    <ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
                        <li class="active"><a data-toggle="tab" href="#basic-info">Basic Info</a></li>
                        <li><a data-toggle="tab" href="#roles-tab">Roles</a></li>
                        <li><a data-toggle="tab" href="#profile-tab">Profile</a></li>
                        <li><a data-toggle="tab" href="#personal-tab">Personal Info</a></li>
                    </ul>

                    <div class="tab-content">

                        {{-- BASIC INFO --}}
                        <div id="basic-info" class="tab-pane active">
                            <h4 class="header blue bolder smaller">Basic Information</h4>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Mobile</label>
                                <div class="col-sm-9">
                                    <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Active</label>
                                <div class="col-sm-9">
                                    <select name="is_active" class="form-control">
                                        <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>

                            {{-- ❗ REMOVED WRONG DUPLICATE is_active FIELD --}}
                        </div>

                        {{-- ROLES ONLY --}}
                        <div id="roles-tab" class="tab-pane">
                            <h4 class="header blue bolder smaller">Assign Roles</h4>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Roles</label>
                                <div class="col-sm-9">
                                    @foreach ($roles as $role)
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="roles[]" value="{{ $role->name }}">
                                            {{ $role->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- PROFILE TAB --}}
                        <div id="profile-tab" class="tab-pane">
                            <h4 class="header blue bolder smaller">Profile</h4>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">User Type</label>
                                <div class="col-sm-9">
                                    <select name="user_type" class="form-control">
                                        <option value="">Select</option>
                                        @foreach (['Admin','Doctor','Nurse','Receptionist','Pharmacist','Lab Technician','Patient','Accountant','Other'] as $type)
                                            <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">User Code</label>
                                <div class="col-sm-9">
                                    <input type="text" name="user_code" class="form-control" value="{{ old('user_code') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Profile Image</label>
                                <div class="col-sm-9">
                                    <input type="file" name="image" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Address</label>
                                <div class="col-sm-9">
                                    <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- PERSONAL TAB --}}
                        <div id="personal-tab" class="tab-pane">
                            <h4 class="header blue bolder smaller">Personal Details</h4>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Gender</label>
                                <div class="col-sm-9">
                                    <select name="gender" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Marital Status</label>
                                <div class="col-sm-9">
                                    <select name="marital_status" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Date of Birth</label>
                                <div class="col-sm-9">
                                    <input type="date" name="date_of_birth" class="form-control"
                                           value="{{ old('date_of_birth') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Joining Date</label>
                                <div class="col-sm-9">
                                    <input type="date" name="joining_date" class="form-control"
                                           value="{{ old('joining_date') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Emergency Contact</label>
                                <div class="col-sm-9">
                                    <input type="text" name="emergency_contact_no" class="form-control"
                                           value="{{ old('emergency_contact_no') }}">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn btn-info btn-sm">
                            <i class="fa fa-save"></i> Submit
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection 