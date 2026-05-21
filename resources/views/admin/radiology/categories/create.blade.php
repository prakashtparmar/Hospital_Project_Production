@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('radiology-categories.index') }}">Radiology Categories</a>
        </li>
        <li class="active">Add Category</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">Add Radiology Category</h4>
</div>

<div class="row">
    <div class="col-xs-12 col-md-6">

        <form method="POST" action="{{ route('radiology-categories.store') }}" class="form-horizontal">
            @csrf

            <div class="form-group">
                <label class="control-label">Category Name</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="Enter category name"
                    value="{{ old('name') }}"
                    required>
            </div>

            <div class="form-group">
                @can('radiology-categories.create')
                <button type="submit" class="btn btn-success">
                    <i class="ace-icon fa fa-save"></i> Save
                </button>
                @endcan

                <a href="{{ route('radiology-categories.index') }}" class="btn btn-default">
                    <i class="ace-icon fa fa-arrow-left"></i> Back
                </a>
            </div>
        </form>

    </div>
</div>

@endsection
