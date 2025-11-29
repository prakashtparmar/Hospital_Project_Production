@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('patients.index') }}">Patients</a>
        </li>
        <li class="active">Patient Details</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <h4 class="page-title">
        <i class="ace-icon fa fa-user"></i> Patient Details
    </h4>

    <div>

        <a href="{{ route('patients.index') }}" class="btn btn-default btn-sm">
            <i class="fa fa-arrow-left"></i> Back
        </a>

        @can('patients.edit')
        <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary btn-sm">
            <i class="fa fa-pencil"></i> Edit
        </a>
        @endcan

    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-8">

        <div class="profile-user-info profile-user-info-striped">

            <div class="profile-info-row">
                <div class="profile-info-name"> Patient ID </div>
                <div class="profile-info-value">
                    <span>{{ $patient->patient_id }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Full Name </div>
                <div class="profile-info-value">
                    <span>{{ $patient->full_name }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Gender </div>
                <div class="profile-info-value">
                    <span>{{ $patient->gender }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Age </div>
                <div class="profile-info-value">
                    <span>{{ $patient->age ?? '---' }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Phone </div>
                <div class="profile-info-value">
                    <span>{{ $patient->phone ?? '---' }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Email </div>
                <div class="profile-info-value">
                    <span>{{ $patient->email ?? '---' }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Department </div>
                <div class="profile-info-value">
                    <span>{{ $patient->department->name ?? '---' }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Status </div>
                <div class="profile-info-value">
                    @if($patient->status)
                        <span class="label label-success">Active</span>
                    @else
                        <span class="label label-danger">Inactive</span>
                    @endif
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Address </div>
                <div class="profile-info-value">
                    <span>{{ $patient->address ?? '---' }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Created At </div>
                <div class="profile-info-value">
                    <span>{{ $patient->created_at ? $patient->created_at->format('d M, Y') : '---' }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Updated At </div>
                <div class="profile-info-value">
                    <span>{{ $patient->updated_at ? $patient->updated_at->format('d M, Y') : '---' }}</span>
                </div>
            </div>

        </div>

    </div>

    {{-- Optional Profile Photo Section --}}
    <div class="col-md-4">
        <div class="text-center">

            <div class="widget-box">
                <div class="widget-header">
                    <h5 class="widget-title">Profile Photo</h5>
                </div>

                <div class="widget-body">
                    <div class="widget-main text-center">

                        <img src="https://via.placeholder.com/150"
                             class="img-responsive"
                             style="border-radius:8px; margin:auto;">

                        <p class="mt-2 text-muted">No custom photo uploaded</p>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
