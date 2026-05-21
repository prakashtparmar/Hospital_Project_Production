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
        <li class="active">Add Unit</li>
    </ul>
</div>
@endsection


@section('content')

<div class="page-header">
    <h4 class="page-title">Add Medicine Unit</h4>
</div>

<div class="row">
<div class="col-xs-12">

    {{-- ERROR MESSAGE --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade in">
            <button class="close" data-dismiss="alert">&times;</button>
            <i class="ace-icon fa fa-exclamation-triangle"></i>
            Please correct the errors below.
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
                      action="{{ route('medicine-units.store') }}">
                    
                    @csrf

                    {{-- NAME --}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">
                            Unit Name <span class="text-danger">*</span>
                        </label>

                        <div class="col-sm-9">
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="col-xs-12 col-sm-6 form-control"
                                   placeholder="Example: Tablet, Strip, Bottle, Vial"
                                   required>

                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
                                <option value="Solid">Solid (Tablet, Capsule, Strip)</option>
                                <option value="Liquid">Liquid (Bottle, Syrup)</option>
                                <option value="Injection">Injection (Vial, Ampoule)</option>
                                <option value="Topical">Topical (Ointment, Cream, Gel)</option>
                                <option value="Drops">Drops (Eye/Ear/Nasal)</option>
                                <option value="Powder">Powder / Sachet</option>
                                <option value="Other">Other</option>
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
                                      class="col-xs-12 col-sm-6 form-control"
                                      placeholder="Optional notes about this unit...">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    {{-- STATUS --}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">
                            Status
                        </label>

                        <div class="col-sm-9">
                            <select name="status" class="col-xs-12 col-sm-6 form-control">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    {{-- FORM BUTTONS --}}
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">

                            <button type="submit" class="btn btn-success">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                Save Unit
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
