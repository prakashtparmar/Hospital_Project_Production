@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('medicine-units.index') }}">Medicine Units</a>
        </li>
        <li class="active">Edit Unit</li>
    </ul>
</div>
@endsection


@section('content')

<div class="page-header">
    <h4 class="page-title">Edit Medicine Unit</h4>
</div>

<div class="row">
<div class="col-xs-12">

    {{-- VALIDATION ERRORS --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade in">
            <button class="close" data-dismiss="alert">&times;</button>
            <i class="ace-icon fa fa-exclamation-triangle"></i>
            Please correct the errors below.
        </div>
    @endif

    {{-- SUCCESS MESSAGE --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade in">
            <button class="close" data-dismiss="alert">&times;</button>
            <i class="ace-icon fa fa-check"></i>
            {{ session('success') }}
        </div>
    @endif


    <div class="widget-box">
        <div class="widget-header">
            <h4 class="widget-title">Unit Details</h4>
        </div>

        <div class="widget-body">
            <div class="widget-main">

                <form class="form-horizontal"
                      method="POST"
                      action="{{ route('medicine-units.update', $medicine_unit->id) }}">
                    
                    @csrf
                    @method('PUT')


                    {{-- UNIT NAME --}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">
                            Unit Name <span class="text-danger">*</span>
                        </label>

                        <div class="col-sm-9">
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $medicine_unit->name) }}"
                                   class="col-xs-12 col-sm-6 form-control"
                                   required>

                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    {{-- SLUG (READ ONLY) --}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">
                            Slug
                        </label>

                        <div class="col-sm-9">
                            <input type="text"
                                   class="col-xs-12 col-sm-6 form-control"
                                   value="{{ $medicine_unit->slug }}"
                                   readonly>
                        </div>
                    </div>


                    {{-- UNIT TYPE --}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">
                            Unit Type
                        </label>

                        <div class="col-sm-9">
                            <select name="type" class="col-xs-12 col-sm-6 form-control">
                                <option value="">Select Type</option>
                                <option value="Solid" {{ $medicine_unit->type == 'Solid' ? 'selected' : '' }}>Solid (Tablet, Capsule, Strip)</option>
                                <option value="Liquid" {{ $medicine_unit->type == 'Liquid' ? 'selected' : '' }}>Liquid (Bottle, Syrup)</option>
                                <option value="Injection" {{ $medicine_unit->type == 'Injection' ? 'selected' : '' }}>Injection (Vial, Ampoule)</option>
                                <option value="Topical" {{ $medicine_unit->type == 'Topical' ? 'selected' : '' }}>Topical (Ointment, Cream)</option>
                                <option value="Drops" {{ $medicine_unit->type == 'Drops' ? 'selected' : '' }}>Drops (Eye/Ear/Nasal)</option>
                                <option value="Powder" {{ $medicine_unit->type == 'Powder' ? 'selected' : '' }}>Powder/Sachet</option>
                                <option value="Other" {{ $medicine_unit->type == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>


                    {{-- DESCRIPTION --}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">
                            Description
                        </label>

                        <div class="col-sm-9">
                            <textarea name="description"
                                      rows="3"
                                      class="col-xs-12 col-sm-6 form-control">{{ old('description', $medicine_unit->description) }}</textarea>

                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    {{-- STATUS --}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">
                            Status
                        </label>

                        <div class="col-sm-9">
                            <select name="status" class="col-xs-12 col-sm-6 form-control">
                                <option value="1" {{ $medicine_unit->status ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$medicine_unit->status ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>


                    {{-- FORM BUTTONS --}}
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">

                            <button type="submit" class="btn btn-success">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                Update Unit
                            </button>

                            &nbsp;&nbsp;

                            <a href="{{ route('medicine-units.index') }}"
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
