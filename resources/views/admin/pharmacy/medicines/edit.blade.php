@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">

    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>

        <li>
            <a href="{{ route('medicines.index') }}">Medicine Master</a>
        </li>

        <li class="active">Edit Medicine</li>
    </ul>

</div>
@endsection


@section('content')

<div class="page-header">
    <h4 class="page-title">Edit Medicine</h4>
</div>

<div class="row">
    <div class="col-xs-12">

        {{-- ERRORS --}}
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade in">
            <button class="close" data-dismiss="alert">&times;</button>
            <i class="ace-icon fa fa-exclamation-triangle"></i>
            Please check the highlighted fields.
        </div>
        @endif

        {{-- SUCCESS --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade in">
            <button class="close" data-dismiss="alert">&times;</button>
            <i class="ace-icon fa fa-check"></i>
            {{ session('success') }}
        </div>
        @endif


        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Medicine Information</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main">


                    <form class="form-horizontal"
                          method="POST"
                          action="{{ route('medicines.update', $medicine->id) }}">

                        @csrf
                        @method('PUT')


                        {{-- NAME --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">
                                Medicine Name <span class="text-danger">*</span>
                            </label>

                            <div class="col-sm-9">
                                <input type="text"
                                       name="name"
                                       value="{{ old('name', $medicine->name) }}"
                                       class="col-xs-12 col-sm-6 form-control"
                                       required>
                            </div>
                        </div>


                        {{-- SLUG (READ ONLY) --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Slug</label>

                            <div class="col-sm-9">
                                <input type="text"
                                       class="col-xs-12 col-sm-6 form-control"
                                       value="{{ $medicine->slug }}"
                                       readonly>
                            </div>
                        </div>


                        {{-- SKU (READ ONLY) --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">SKU</label>

                            <div class="col-sm-9">
                                <input type="text"
                                       class="col-xs-12 col-sm-6 form-control"
                                       value="{{ $medicine->sku }}"
                                       readonly>
                            </div>
                        </div>


                        {{-- BARCODE (READ ONLY) --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Barcode</label>

                            <div class="col-sm-9">
                                <input type="text"
                                       class="col-xs-12 col-sm-6 form-control"
                                       value="{{ $medicine->barcode }}"
                                       readonly>
                            </div>
                        </div>


                        {{-- CATEGORY --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Category</label>

                            <div class="col-sm-9">
                                <select name="category_id"
                                        class="col-xs-12 col-sm-6 form-control"
                                        required>
                                    <option value="">Select Category</option>

                                    @foreach($categories as $c)
                                    <option value="{{ $c->id }}"
                                        {{ $medicine->category_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        {{-- UNIT --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Unit</label>

                            <div class="col-sm-9">
                                <select name="unit_id"
                                        class="col-xs-12 col-sm-6 form-control"
                                        required>
                                    <option value="">Select Unit</option>

                                    @foreach($units as $u)
                                    <option value="{{ $u->id }}"
                                        {{ $medicine->unit_id == $u->id ? 'selected' : '' }}>
                                        {{ $u->name }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        {{-- STRENGTH --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Strength</label>

                            <div class="col-sm-9">
                                <input name="strength"
                                       value="{{ old('strength', $medicine->strength) }}"
                                       class="col-xs-12 col-sm-6 form-control"
                                       placeholder="e.g. 500mg">
                            </div>
                        </div>


                        {{-- COMPOSITION --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Composition</label>

                            <div class="col-sm-9">
                                <textarea name="composition"
                                          class="col-xs-12 col-sm-6 form-control"
                                          rows="2">{{ old('composition', $medicine->composition) }}</textarea>
                            </div>
                        </div>


                        {{-- MANUFACTURER --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Manufacturer</label>

                            <div class="col-sm-9">
                                <input name="manufacturer"
                                       value="{{ old('manufacturer', $medicine->manufacturer) }}"
                                       class="col-xs-12 col-sm-6 form-control">
                            </div>
                        </div>


                        {{-- BATCH --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Batch No.</label>

                            <div class="col-sm-9">
                                <input name="batch_no"
                                       value="{{ old('batch_no', $medicine->batch_no) }}"
                                       class="col-xs-12 col-sm-6 form-control">
                            </div>
                        </div>


                        {{-- EXPIRY --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Expiry Date</label>

                            <div class="col-sm-9">
                                <input type="date"
                                       name="expiry_date"
                                       value="{{ old('expiry_date', $medicine->expiry_date) }}"
                                       class="col-xs-12 col-sm-6 form-control">
                            </div>
                        </div>


                        {{-- MRP --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">MRP (₹)</label>

                            <div class="col-sm-9">
                                <input type="number"
                                       step="0.01"
                                       name="mrp"
                                       value="{{ old('mrp', $medicine->mrp) }}"
                                       class="col-xs-12 col-sm-6 form-control"
                                       required>
                            </div>
                        </div>


                        {{-- PURCHASE RATE --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Purchase Rate</label>

                            <div class="col-sm-9">
                                <input type="number"
                                       step="0.01"
                                       name="purchase_rate"
                                       value="{{ old('purchase_rate', $medicine->purchase_rate) }}"
                                       class="col-xs-12 col-sm-6 form-control">
                            </div>
                        </div>


                        {{-- TAX --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Tax (%)</label>

                            <div class="col-sm-9">
                                <input type="number"
                                       step="0.01"
                                       name="tax_percent"
                                       value="{{ old('tax_percent', $medicine->tax_percent) }}"
                                       class="col-xs-12 col-sm-6 form-control">
                            </div>
                        </div>


                        {{-- MARGIN --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Margin (%)</label>

                            <div class="col-sm-9">
                                <input type="number"
                                       step="0.01"
                                       name="margin_percent"
                                       value="{{ old('margin_percent', $medicine->margin_percent) }}"
                                       class="col-xs-12 col-sm-6 form-control">
                            </div>
                        </div>


                        {{-- REORDER LEVEL --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">
                                Reorder Level
                            </label>

                            <div class="col-sm-9">
                                <input type="number"
                                       name="reorder_level"
                                       value="{{ old('reorder_level', $medicine->reorder_level) }}"
                                       class="col-xs-12 col-sm-6 form-control">
                            </div>
                        </div>


                        {{-- STORAGE CONDITION --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Storage Condition</label>

                            <div class="col-sm-9">
                                <input name="storage_condition"
                                       value="{{ old('storage_condition', $medicine->storage_condition) }}"
                                       class="col-xs-12 col-sm-6 form-control">
                            </div>
                        </div>


                        {{-- DRUG TYPE --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Drug Type</label>

                            <div class="col-sm-9">
                                <select name="drug_type"
                                        class="col-xs-12 col-sm-6 form-control">

                                    <option value="OTC" {{ $medicine->drug_type == 'OTC' ? 'selected' : '' }}>OTC</option>
                                    <option value="Schedule H" {{ $medicine->drug_type == 'Schedule H' ? 'selected' : '' }}>Schedule H</option>
                                    <option value="Schedule H1" {{ $medicine->drug_type == 'Schedule H1' ? 'selected' : '' }}>Schedule H1</option>
                                    <option value="Schedule G" {{ $medicine->drug_type == 'Schedule G' ? 'selected' : '' }}>Schedule G</option>

                                </select>
                            </div>
                        </div>


                        {{-- STATUS --}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Status</label>

                            <div class="col-sm-9">
                                <select name="status"
                                        class="col-xs-12 col-sm-6 form-control">

                                    <option value="1" {{ $medicine->status ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$medicine->status ? 'selected' : '' }}>Inactive</option>

                                </select>
                            </div>
                        </div>


                        {{-- BUTTONS --}}
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">

                                <button type="submit" class="btn btn-success">
                                    <i class="ace-icon fa fa-check"></i> Update
                                </button>

                                &nbsp;

                                <a href="{{ route('medicines.index') }}"
                                   class="btn btn-default">
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
