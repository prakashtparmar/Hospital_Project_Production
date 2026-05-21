@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('admin.hospitals.index') }}">Hospitals</a>
        </li>
        <li class="active">Edit Hospital</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">Edit Hospital</h4>
</div>

{{-- Validation Errors --}}
@if($errors->any())
<div class="alert alert-danger">
    <ul class="m-0 pl-3">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.hospitals.update', $hospital->id) }}"
      method="POST"
      class="form-horizontal">

    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-8">

            {{-- Name --}}
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    Hospital Name <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', data_get($hospital->data, 'name')) }}"
                           required>
                </div>
            </div>

            {{-- Contact --}}
            <div class="form-group">
                <label class="col-sm-3 control-label">Contact</label>

                <div class="col-sm-9">
                    <input type="text"
                           name="contact"
                           class="form-control"
                           value="{{ old('contact', data_get($hospital->data, 'contact')) }}">
                </div>
            </div>

            {{-- Subdomain --}}
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    Subdomain <span class="text-danger">*</span>
                </label>

                <div class="col-sm-9">
                    <div class="input-group">

                        <input type="text"
                               name="subdomain"
                               class="form-control"
                               value="{{ old('subdomain', $subdomain) }}"
                               required>

                        <span class="input-group-addon">.{{ $baseDomain }}</span>

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Buttons --}}
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">

            <button class="btn btn-success" type="submit">
                <i class="ace-icon fa fa-save"></i> Update
            </button>

            <a href="{{ route('admin.hospitals.index') }}" class="btn btn-danger">
                <i class="ace-icon fa fa-times"></i> Cancel
            </a>

        </div>
    </div>

</form>

@endsection
