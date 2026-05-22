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
        <li class="active">Edit Category</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">Edit Radiology Category</h4>
</div>

<div class="row">
    <div class="col-xs-12 col-md-6">

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
              action="{{ route('radiology-categories.update', $radiology_category->id) }}"
              class="form-horizontal">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="control-label">Category Name</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $radiology_category->name) }}"
                       class="form-control"
                       required>
            </div>

            <div class="form-group">
                @can('radiology-categories.edit')
                <button class="btn btn-success">
                    <i class="ace-icon fa fa-save"></i> Update
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
