@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('lab-tests.index') }}">Lab Tests</a>
        </li>
        <li>
            <a href="{{ route('lab.parameters.index', $lab_test->id) }}">{{ $lab_test->name }} Parameters</a>
        </li>
        <li class="active">Edit Parameter</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">Edit Parameter</h4>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-8">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('lab.parameters.update', [$lab_test->id, $parameter->id]) }}"
              class="form-horizontal">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Name <span class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $parameter->name) }}"
                           required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Unit</label>
                <div class="col-sm-9">
                    <input type="text"
                           name="unit"
                           class="form-control"
                           value="{{ old('unit', $parameter->unit) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Reference Range</label>
                <div class="col-sm-9">
                    <input type="text"
                           name="reference_range"
                           class="form-control"
                           value="{{ old('reference_range', $parameter->reference_range) }}">
                </div>
            </div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-success">
                        <i class="ace-icon fa fa-check"></i>
                        Update
                    </button>

                    <a href="{{ route('lab.parameters.index', $lab_test->id) }}" class="btn btn-grey">
                        <i class="ace-icon fa fa-arrow-left"></i>
                        Back
                    </a>
                </div>
            </div>
        </form>

    </div>
</div>

@endsection
