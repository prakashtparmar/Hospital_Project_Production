@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li><a href="{{ route('medicines.index') }}">Medicine Master</a></li>
        <li class="active">Add Medicine</li>
    </ul>
</div>
@endsection


@section('content')

<div class="page-header">
    <h4 class="page-title">Add Medicine</h4>
</div>

<div class="row">
    <div class="col-xs-12">

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade in">
                <button class="close" data-dismiss="alert">&times;</button>
                <i class="ace-icon fa fa-exclamation-triangle"></i>
                Please fix the highlighted fields.
            </div>
        @endif

        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Medicine Information</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <form class="form-horizontal" method="POST"
                          action="{{ route('medicines.store') }}">
                        @csrf

                        {{-- NAME --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">
                                Medicine Name <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input name="name" class="col-xs-12 col-sm-6 form-control"
                                       value="{{ old('name') }}" required>
                            </div>
                        </div>

                        {{-- CATEGORY --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Category</label>
                            <div class="col-sm-9">
                                <select name="category_id" class="col-xs-12 col-sm-6 form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- UNIT --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Unit</label>
                            <div class="col-sm-9">
                                <select name="unit_id" class="col-xs-12 col-sm-6 form-control" required>
                                    <option value="">Select Unit</option>
                                    @foreach($units as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- STRENGTH --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Strength</label>
                            <div class="col-sm-9">
                                <input name="strength" class="col-xs-12 col-sm-6 form-control"
                                       placeholder="e.g. 500mg">
                            </div>
                        </div>

                        {{-- COMPOSITION --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">
                                Composition
                            </label>
                            <div class="col-sm-9">
                                <textarea name="composition" rows="2"
                                          class="col-xs-12 col-sm-6 form-control"></textarea>
                            </div>
                        </div>

                        {{-- MANUFACTURER --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Manufacturer</label>
                            <div class="col-sm-9">
                                <input name="manufacturer" class="col-xs-12 col-sm-6 form-control">
                            </div>
                        </div>

                        {{-- BATCH / EXPIRY --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Batch No.</label>
                            <div class="col-sm-9">
                                <input name="batch_no" class="col-xs-12 col-sm-6 form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Expiry Date</label>
                            <div class="col-sm-9">
                                <input type="date" name="expiry_date"
                                       class="col-xs-12 col-sm-6 form-control">
                            </div>
                        </div>

                        {{-- PRICING --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">MRP (₹)</label>
                            <div class="col-sm-9">
                                <input name="mrp" class="col-xs-12 col-sm-6 form-control"
                                       type="number" step="0.01" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Purchase Rate</label>
                            <div class="col-sm-9">
                                <input name="purchase_rate" type="number" step="0.01"
                                       class="col-xs-12 col-sm-6 form-control">
                            </div>
                        </div>

                        {{-- TAX / MARGIN --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Tax (%)</label>
                            <div class="col-sm-9">
                                <input name="tax_percent" type="number" step="0.01"
                                       class="col-xs-12 col-sm-6 form-control" value="0">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Margin (%)</label>
                            <div class="col-sm-9">
                                <input name="margin_percent" type="number" step="0.01"
                                       class="col-xs-12 col-sm-6 form-control">
                            </div>
                        </div>

                        {{-- REORDER LEVEL --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">
                                Reorder Level
                            </label>
                            <div class="col-sm-9">
                                <input name="reorder_level" type="number" class="col-xs-12 col-sm-6 form-control">
                            </div>
                        </div>

                        {{-- STORAGE --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Storage Condition</label>
                            <div class="col-sm-9">
                                <input name="storage_condition"
                                       class="col-xs-12 col-sm-6 form-control"
                                       placeholder="e.g. Store in cool & dry place">
                            </div>
                        </div>

                        {{-- DRUG TYPE --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Drug Type</label>
                            <div class="col-sm-9">
                                <select name="drug_type" class="col-xs-12 col-sm-6 form-control">
                                    <option value="OTC">OTC</option>
                                    <option value="Schedule H">Schedule H</option>
                                    <option value="Schedule H1">Schedule H1</option>
                                    <option value="Schedule G">Schedule G</option>
                                </select>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">

                                <button class="btn btn-success" type="submit">
                                    <i class="ace-icon fa fa-check bigger-110"></i> Save
                                </button>

                                &nbsp;
                                <a href="{{ route('medicines.index') }}" class="btn btn-default">
                                    <i class="ace-icon fa fa-arrow-left"></i> Back
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
