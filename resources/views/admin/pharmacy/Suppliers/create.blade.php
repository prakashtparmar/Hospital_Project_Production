@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('suppliers.index') }}">Suppliers</a>
        </li>
        <li class="active">Add Supplier</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">Add New Supplier</h4>
</div>

<div class="row">
    <div class="col-xs-12">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="ace-icon fa fa-check"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="ace-icon fa fa-exclamation-triangle"></i> Please fix the errors below.
            </div>
        @endif

        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Supplier Information</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <form class="form-horizontal" method="POST" action="{{ route('suppliers.store') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Name <span class="text-danger">*</span></label>

                            <div class="col-sm-9">
                                <input type="text" name="name" 
                                       class="col-xs-12 col-sm-6 form-control"
                                       value="{{ old('name') }}"
                                       required>

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Contact Person --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Contact Person</label>

                            <div class="col-sm-9">
                                <input type="text" name="contact_person"
                                       class="col-xs-12 col-sm-6 form-control"
                                       value="{{ old('contact_person') }}">

                                @error('contact_person')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Phone</label>

                            <div class="col-sm-9">
                                <input type="text" name="phone"
                                       class="col-xs-12 col-sm-6 form-control"
                                       value="{{ old('phone') }}">

                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Email</label>

                            <div class="col-sm-9">
                                <input type="email" name="email"
                                       class="col-xs-12 col-sm-6 form-control"
                                       value="{{ old('email') }}">

                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Address</label>

                            <div class="col-sm-9">
                                <textarea name="address"
                                          class="col-xs-12 col-sm-6 form-control"
                                          rows="3">{{ old('address') }}</textarea>

                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">

                                <button class="btn btn-success" type="submit">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Save
                                </button>

                                &nbsp; &nbsp;

                                <a href="{{ route('suppliers.index') }}" class="btn btn-default">
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
