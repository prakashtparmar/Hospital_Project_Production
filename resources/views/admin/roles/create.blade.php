@extends('layouts.app')

@section('breadcrumbs')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('roles.index') }}">Roles</a>
            </li>
            <li class="active">Create Role</li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="page-header mb-3">
        <h4 class="page-title">Create Role</h4>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf

                        {{-- Role Name --}}
                        <div class="mb-3">
                            <label class="form-label">Role Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Permission Search --}}
                        <div class="mb-3">
                            <input type="text" id="permissionSearch" class="form-control"
                                placeholder="Search permissions...">
                        </div>

                        {{-- Master Select All --}}
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAllMaster">
                                <label class="form-check-label fw-bold" for="selectAllMaster">Select All Permissions</label>
                            </div>
                        </div>

                        @php
                            $permissionGroups = [

                                'Dashboard' => [
                                    'dashboard.view',
                                ],

                                'Roles' => [
                                    'roles.view',
                                    'roles.create',
                                    'roles.edit',
                                    'roles.delete',
                                ],

                                'Users' => [
                                    'users.view',
                                    'users.create',
                                    'users.edit',
                                    'users.delete',
                                ],

                                'Departments' => [
                                    'departments.view',
                                    'departments.create',
                                    'departments.edit',
                                    'departments.delete',
                                ],

                                'Audit Logs' => [
                                    'auditlogs.view',
                                ],

                                'Notification Settings' => [
                                    'notification-settings.view',
                                    'notification-settings.edit',
                                ],

                                'Doctors' => [
                                    'doctors.view',
                                    'doctors.create',
                                    'doctors.edit',
                                    'doctors.delete',
                                ],

                                'Consultations' => [
                                    'consultations.view',
                                    'consultations.create',
                                    'consultations.edit',
                                    'consultations.end',
                                ],

                                'Patients' => [
                                    'patients.view',
                                    'patients.create',
                                    'patients.edit',
                                    'patients.delete',
                                ],

                                'OPD' => [
                                    'opd.view',
                                    'opd.create',
                                    'opd.edit',
                                    'opd.delete',
                                ],

                                'IPD' => [
                                    'ipd.view',
                                    'ipd.create',
                                    'ipd.edit',
                                    'ipd.delete',
                                ],

                                'Appointments' => [
                                    'appointments.view',
                                    'appointments.create',
                                    'appointments.edit',
                                    'appointments.delete',
                                ],

                                'Doctor Schedule' => [
                                    'doctor-schedule.view',
                                    'doctor-schedule.create',
                                    'doctor-schedule.edit',
                                    'doctor-schedule.delete',
                                ],

                                'Wards' => [
                                    'wards.view',
                                    'wards.create',
                                    'wards.edit',
                                    'wards.delete',
                                ],

                                'Rooms' => [
                                    'rooms.view',
                                    'rooms.create',
                                    'rooms.edit',
                                    'rooms.delete',
                                ],

                                'Beds' => [
                                    'beds.view',
                                    'beds.create',
                                    'beds.edit',
                                    'beds.delete',
                                ],

                                'Medicine Categories' => [
                                    'medicine-categories.view',
                                    'medicine-categories.create',
                                    'medicine-categories.edit',
                                    'medicine-categories.delete',
                                ],

                                'Medicine Units' => [
                                    'medicine-units.view',
                                    'medicine-units.create',
                                    'medicine-units.edit',
                                    'medicine-units.delete',
                                ],

                                'Medicines' => [
                                    'medicines.view',
                                    'medicines.create',
                                    'medicines.edit',
                                    'medicines.delete',
                                ],

                                'Stock Adjustments' => [
                                    'stock-adjustments.view',
                                    'stock-adjustments.create',
                                    'stock-adjustments.edit',
                                    'stock-adjustments.delete',
                                ],

                                'Suppliers' => [
                                    'suppliers.view',
                                    'suppliers.create',
                                    'suppliers.edit',
                                    'suppliers.delete',
                                ],

                                'Purchases' => [
                                    'purchases.view',
                                    'purchases.create',
                                    'purchases.edit',
                                    'purchases.delete',
                                ],

                                'Issue Medicines' => [
                                    'issue-medicines.view',
                                    'issue-medicines.create',
                                    'issue-medicines.edit',
                                    'issue-medicines.delete',
                                ],

                                'Lab Test Categories' => [
                                    'lab-test-categories.view',
                                    'lab-test-categories.create',
                                    'lab-test-categories.edit',
                                    'lab-test-categories.delete',
                                ],

                                'Lab Tests' => [
                                    'lab-tests.view',
                                    'lab-tests.create',
                                    'lab-tests.edit',
                                    'lab-tests.delete',
                                ],

                                'Lab Requests' => [
                                    'lab-requests.view',
                                    'lab-requests.create',
                                    'lab-requests.edit',
                                    'lab-requests.delete',
                                ],

                                'Radiology Categories' => [
                                    'radiology-categories.view',
                                    'radiology-categories.create',
                                    'radiology-categories.edit',
                                    'radiology-categories.delete',
                                ],

                                'Radiology Tests' => [
                                    'radiology-tests.view',
                                    'radiology-tests.create',
                                    'radiology-tests.edit',
                                    'radiology-tests.delete',
                                ],

                                'Radiology Requests' => [
                                    'radiology-requests.view',
                                    'radiology-requests.create',
                                    'radiology-requests.edit',
                                    'radiology-requests.delete',
                                ],

                                'Billing' => [
                                    'billing.view',
                                    'billing.create',
                                    'billing.edit',
                                    'billing.delete',
                                ],

                                'Employees' => [
                                    'employees.view',
                                    'employees.create',
                                    'employees.edit',
                                    'employees.delete',
                                ],

                                'Leave Types' => [
                                    'leave-types.view',
                                    'leave-types.create',
                                    'leave-types.edit',
                                    'leave-types.delete',
                                ],

                                'Leave Applications' => [
                                    'leave-applications.view',
                                    'leave-applications.create',
                                    'leave-applications.edit',
                                    'leave-applications.delete',
                                ],

                                'Attendance' => [
                                    'attendance.view',
                                    'attendance.create',
                                    'attendance.edit',
                                    'attendance.delete',
                                ],

                                'Salary Structures' => [
                                    'salary-structures.view',
                                    'salary-structures.create',
                                    'salary-structures.edit',
                                    'salary-structures.delete',
                                ],

                                'Payroll' => [
                                    'payroll.view',
                                    'payroll.create',
                                    'payroll.edit',
                                    'payroll.delete',
                                ],

                                'Export' => [
                                    'export.view',
                                ],

                                'Hospitals' => [
                                    'hospitals.view',
                                    'hospitals.create',
                                    'hospitals.edit',
                                    'hospitals.delete',
                                ],

                            ];
                        @endphp


                        {{-- Permission Groups --}}
                        <div id="permissionContainer" class="row">
                            @foreach ($permissionGroups as $groupName => $groupPermissions)
                                <div class="col-lg-4 col-md-6 mb-3 permission-group-card">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">{{ $groupName }}</span>
                                            <div class="form-check mb-0">
                                                <input class="form-check-input selectGroup" type="checkbox"
                                                    id="group-{{ Str::slug($groupName) }}">
                                                <label class="form-check-label"
                                                    for="group-{{ Str::slug($groupName) }}">All</label>
                                            </div>
                                        </div>
                                        <div class="card-body p-2" style="max-height: 200px; overflow-y: auto;">
                                            @foreach ($groupPermissions as $perm)
                                                <div class="form-check permission-item">
                                                    <input class="form-check-input group-{{ Str::slug($groupName) }}"
                                                        type="checkbox" name="permissions[]" value="{{ $perm }}"
                                                        id="perm-{{ Str::slug($perm) }}">
                                                    <label class="form-check-label"
                                                        for="perm-{{ Str::slug($perm) }}">{{ $perm }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Create Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection