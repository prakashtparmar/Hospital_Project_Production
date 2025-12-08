@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('lab-test-categories.index') }}">Lab Categories</a>
        </li>
        <li class="active">Add</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">
        Add Lab Test Category
    </h4>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-8">

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('lab-test-categories.store') }}" class="form-horizontal">
            @csrf

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">
                    Category Name
                </label>

                <div class="col-sm-9">
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        required
                    >
                </div>
            </div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-success">
                        <i class="ace-icon fa fa-check"></i>
                        Save
                    </button>

                    <a href="{{ route('lab-test-categories.index') }}" class="btn btn-grey">
                        <i class="ace-icon fa fa-arrow-left"></i>
                        Back
                    </a>
                </div>
            </div>

        </form>

    </div>
</div>

@endsection
