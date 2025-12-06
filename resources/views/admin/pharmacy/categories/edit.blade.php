@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('medicine-categories.index') }}">Medicine Categories</a>
        </li>
        <li class="active">Edit Category</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">Edit Medicine Category</h4>
</div>

<div class="row">
    <div class="col-xs-12">

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade in">
                <button class="close" data-dismiss="alert">&times;</button>
                <i class="ace-icon fa fa-exclamation-triangle"></i>
                Please fix the highlighted errors.
            </div>
        @endif

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade in">
                <button class="close" data-dismiss="alert">&times;</button>
                <i class="ace-icon fa fa-check"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Category Details</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <form class="form-horizontal"
                          method="POST"
                          action="{{ route('medicine-categories.update', $medicine_category->id) }}">

                        @csrf
                        @method('PUT')

                        {{-- Name --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">
                                Category Name <span class="text-danger">*</span>
                            </label>

                            <div class="col-sm-9">
                                <input type="text"
                                       name="name"
                                       class="col-xs-12 col-sm-6 form-control"
                                       value="{{ old('name', $medicine_category->name) }}"
                                       required>

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">
                                Description
                            </label>

                            <div class="col-sm-9">
                                <textarea name="description"
                                          rows="3"
                                          class="col-xs-12 col-sm-6 form-control">{{ old('description', $medicine_category->description) }}</textarea>

                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Status</label>

                            <div class="col-sm-9">
                                <select name="status" class="col-xs-12 col-sm-6 form-control">
                                    <option value="1" {{ $medicine_category->status ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$medicine_category->status ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">

                                <button type="submit" class="btn btn-success">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Update Category
                                </button>

                                &nbsp;&nbsp;

                                <a href="{{ route('medicine-categories.index') }}"
                                   class="btn btn-default">
                                    <i class="ace-icon fa fa-arrow-left bigger-110"></i>
                                    Back
                                </a>

                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

@endsection
