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
        <li class="active">Create Hospital</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">Create Hospital</h4>
</div>

@if($errors->any())
<div class="alert alert-danger">
    <ul class="m-0 pl-3">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.hospitals.store') }}"
      method="POST"
      class="form-horizontal"
      autocomplete="off">

    @csrf

    <div class="row">
        <div class="col-md-8">

            {{-- Hospital Name --}}
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label class="col-sm-3 control-label">
                    Hospital Name <span class="text-danger">*</span>
                </label>

                <div class="col-sm-9">
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control"
                           required>
                </div>
            </div>

            {{-- Contact --}}
            <div class="form-group {{ $errors->has('contact') ? 'has-error' : '' }}">
                <label class="col-sm-3 control-label">Contact</label>

                <div class="col-sm-9">
                    <input type="text"
                           name="contact"
                           value="{{ old('contact') }}"
                           class="form-control">
                </div>
            </div>

            {{-- Subdomain --}}
            <div class="form-group {{ $errors->has('subdomain') ? 'has-error' : '' }}">
                <label class="col-sm-3 control-label">
                    Subdomain <span class="text-danger">*</span>
                </label>

                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text"
                               name="subdomain"
                               value="{{ old('subdomain') }}"
                               class="form-control"
                               required>

                        <span class="input-group-addon">
                            .{{ config('app.base_domain', 'main.localhost') }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">

            <button class="btn btn-success" type="submit">
                <i class="ace-icon fa fa-check"></i> Create
            </button>

            <a href="{{ route('admin.hospitals.index') }}" class="btn btn-danger">
                <i class="ace-icon fa fa-times"></i> Cancel
            </a>

        </div>
    </div>

</form>

@endsection
