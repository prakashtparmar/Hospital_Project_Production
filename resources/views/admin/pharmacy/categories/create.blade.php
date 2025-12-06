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
        <li class="active">Add Category</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">Add Medicine Category</h4>
</div>

<div class="row">
    <div class="col-xs-12">

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade in">
                <button class="close" data-dismiss="alert">&times;</button>
                <i class="ace-icon fa fa-exclamation-triangle"></i> Please fix the highlighted fields.
            </div>
        @endif

        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Category Details</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <form class="form-horizontal" method="POST" action="{{ route('medicine-categories.store') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">
                                Category Name <span class="text-danger">*</span>
                            </label>

                            <div class="col-sm-9">
                                <input type="text"
                                       name="name"
                                       value="{{ old('name') }}"
                                       class="col-xs-12 col-sm-6 form-control"
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
                                          class="col-xs-12 col-sm-6 form-control">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Status</label>

                            <div class="col-sm-9">
                                <select name="status" class="col-xs-12 col-sm-6 form-control">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">

                                <button type="submit" class="btn btn-success">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Save Category
                                </button>

                                &nbsp;&nbsp;

                                <a href="{{ route('medicine-categories.index') }}" class="btn btn-default">
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
