@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Users</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Users</h4>

    @can('users.create')
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addUserModal">
            <i class="fa fa-plus"></i> Add User
        </button>
    @endcan
</div>

<div class="card">
    <div class="card-header"><strong>Users Management</strong></div>

    <div class="card-body table-responsive">

        <table class="table table-bordered table-striped table-hover datatable">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Email Verified</th>
                    <th>Status</th>
                    <th>Roles</th>
                    <th>Created At</th>
                    <th>Last Login IP</th>
                    <th>Last Activity</th>
                    <th>Device</th>
                    <th width="160" class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>

            @foreach ($users as $user)

                <tr>
                    <td>{{ $user->id }}</td>

                    <td>
                        <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('ace/assets/images/avatars/profile-pic.jpg') }}"
                             style="width:45px;height:45px;border-radius:50%;object-fit:cover;">
                    </td>

                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <td>
                        @if($user->email_verified_at)
                            <span class="label label-success">Verified</span>
                        @else
                            <span class="label label-warning">Pending</span>
                        @endif
                    </td>

                    <td>
                        @if($user->is_active)
                            <span class="label label-success">Active</span>
                        @else
                            <span class="label label-danger">Inactive</span>
                        @endif
                    </td>

                    <td>
                        @foreach($user->roles as $role)
                            <span class="label label-info">{{ $role->name }}</span>
                        @endforeach
                    </td>

                    <td>{{ $user->created_at->format('d M Y') }}</td>

                    <td>{{ $user->ip_address ?? '---' }}</td>

                    <td>
                        {{ $user->last_activity ? \Carbon\Carbon::createFromTimestamp($user->last_activity)->diffForHumans() : '---' }}
                    </td>

                    <td>{{ $user->user_agent ? substr($user->user_agent, 0, 25) . '...' : '---' }}</td>

                    <td class="text-center">

                        {{-- EDIT --}}
                        <button class="btn btn-success btn-sm"
                                data-toggle="modal"
                                data-target="#editUserModal{{ $user->id }}">
                            <i class="fa fa-pencil"></i>
                        </button>

                        {{-- DELETE --}}
                        <form action="{{ route('users.destroy', $user->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete user?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>

                    </td>

                </tr>


                {{-- ######################################################## --}}
                {{-- EDIT USER MODAL (FULL TABS LIKE CREATE USER PAGE) --}}
                {{-- ######################################################## --}}
                <div class="modal fade" id="editUserModal{{ $user->id }}">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Edit User – {{ $user->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                            </div>

                            <form action="{{ route('users.update', $user->id) }}"
                                  method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="modal-body">

                                    <ul class="nav nav-tabs mb-3">
                                        <li class="active"><a data-toggle="tab" href="#edit-basic-{{ $user->id }}">Basic Info</a></li>
                                        <li><a data-toggle="tab" href="#edit-roles-{{ $user->id }}">Roles</a></li>
                                        <li><a data-toggle="tab" href="#edit-profile-{{ $user->id }}">Profile</a></li>
                                        <li><a data-toggle="tab" href="#edit-personal-{{ $user->id }}">Personal</a></li>
                                    </ul>

                                    <div class="tab-content">

                                        {{-- BASIC --}}
                                        <div id="edit-basic-{{ $user->id }}" class="tab-pane fade in active">
                                            <div class="row">

                                                <div class="col-md-6 mb-3">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" name="name"
                                                           value="{{ $user->name }}" required>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" name="email"
                                                           value="{{ $user->email }}" required>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label>Password (Optional)</label>
                                                    <input type="password" class="form-control" name="password">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label>Mobile</label>
                                                    <input type="text" class="form-control" name="mobile"
                                                           value="{{ $user->mobile }}">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label>Status</label>
                                                    <select name="is_active" class="form-control">
                                                        <option value="1" {{ $user->is_active ? 'selected':'' }}>Active</option>
                                                        <option value="0" {{ !$user->is_active ? 'selected':'' }}>Inactive</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>

                                        {{-- ROLES --}}
                                        <div id="edit-roles-{{ $user->id }}" class="tab-pane fade">
                                            <h6>Assign Roles</h6>

                                            @foreach($roles as $role)
                                                <label class="checkbox-inline mb-2">
                                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                                           {{ $user->roles->contains('name', $role->name) ? 'checked' : '' }}>
                                                    {{ $role->name }}
                                                </label>
                                            @endforeach
                                        </div>

                                        {{-- PROFILE --}}
                                        <div id="edit-profile-{{ $user->id }}" class="tab-pane fade">
                                            <div class="row">

                                                <div class="col-md-6 mb-3">
                                                    <label>User Type</label>
                                                    <select name="user_type" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach(['Admin','Doctor','Nurse','Receptionist','Pharmacist','Lab Technician','Patient','Accountant','Other'] as $type)
                                                            <option value="{{ $type }}"
                                                                {{ $user->user_type == $type ? 'selected':'' }}>
                                                                {{ $type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label>User Code</label>
                                                    <input type="text" name="user_code" class="form-control"
                                                           value="{{ $user->user_code }}">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label>Profile Image</label>
                                                    <input type="file" name="image" class="form-control">
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label>Address</label>
                                                    <textarea name="address" class="form-control" rows="2">{{ $user->address }}</textarea>
                                                </div>

                                            </div>
                                        </div>

                                        {{-- PERSONAL --}}
                                        <div id="edit-personal-{{ $user->id }}" class="tab-pane fade">
                                            <div class="row">

                                                <div class="col-md-6 mb-3">
                                                    <label>Gender</label>
                                                    <select name="gender" class="form-control">
                                                        <option value="">Select</option>
                                                        <option {{ $user->gender == 'Male' ? 'selected':'' }}>Male</option>
                                                        <option {{ $user->gender == 'Female' ? 'selected':'' }}>Female</option>
                                                        <option {{ $user->gender == 'Other' ? 'selected':'' }}>Other</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label>Marital Status</label>
                                                    <select name="marital_status" class="form-control">
                                                        <option value="">Select</option>
                                                        <option {{ $user->marital_status == 'Single' ? 'selected':'' }}>Single</option>
                                                        <option {{ $user->marital_status == 'Married' ? 'selected':'' }}>Married</option>
                                                        <option {{ $user->marital_status == 'Other' ? 'selected':'' }}>Other</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label>Date of Birth</label>
                                                    <input type="date" name="date_of_birth" class="form-control"
                                                           value="{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '' }}"
>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label>Joining Date</label>
                                                    <input type="date" name="joining_date" class="form-control"
                                                           value="{{ $user->joining_date ? \Carbon\Carbon::parse($user->joining_date)->format('Y-m-d') : '' }}"
>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label>Emergency Contact</label>
                                                    <input type="text" name="emergency_contact_no" class="form-control"
                                                           value="{{ $user->emergency_contact_no }}">
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-primary"><i class="fa fa-save"></i> Update User</button>
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


{{-- ################################################ --}}
{{-- ADD USER MODAL --}}
{{-- ################################################ --}}
<div class="modal fade" id="addUserModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <ul class="nav nav-tabs mb-3">
                        <li class="active"><a data-toggle="tab" href="#add-basic">Basic Info</a></li>
                        <li><a data-toggle="tab" href="#add-roles">Roles</a></li>
                        <li><a data-toggle="tab" href="#add-profile">Profile</a></li>
                        <li><a data-toggle="tab" href="#add-personal">Personal</a></li>
                    </ul>

                    <div class="tab-content">

                        {{-- BASIC --}}
                        <div id="add-basic" class="tab-pane fade in active">
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Mobile</label>
                                    <input type="text" name="mobile" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Status</label>
                                    <select name="is_active" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        {{-- ROLES --}}
                        <div id="add-roles" class="tab-pane fade">
                            <h6>Select Roles</h6>

                            @foreach($roles as $role)
                                <label class="checkbox-inline mb-2">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}">
                                    {{ $role->name }}
                                </label>
                            @endforeach
                        </div>

                        {{-- PROFILE --}}
                        <div id="add-profile" class="tab-pane fade">

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>User Type</label>
                                    <select name="user_type" class="form-control">
                                        <option value="">Select</option>
                                        @foreach(['Admin','Doctor','Nurse','Receptionist','Pharmacist','Lab Technician','Patient','Accountant','Other'] as $type)
                                            <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>User Code</label>
                                    <input type="text" name="user_code" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Profile Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Address</label>
                                    <textarea name="address" class="form-control" rows="2"></textarea>
                                </div>

                            </div>

                        </div>

                        {{-- PERSONAL --}}
                        <div id="add-personal" class="tab-pane fade">

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control">
                                        <option value="">Select</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                        <option>Other</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Marital Status</label>
                                    <select name="marital_status" class="form-control">
                                        <option value="">Select</option>
                                        <option>Single</option>
                                        <option>Married</option>
                                        <option>Other</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Joining Date</label>
                                    <input type="date" name="joining_date" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Emergency Contact</label>
                                    <input type="text" name="emergency_contact_no" class="form-control">
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Save User</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
