@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('lab-tests.index') }}">Lab Tests</a>
        </li>
        <li class="active">Edit</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">Edit Lab Test</h4>
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

        <form method="POST"
              action="{{ route('lab-tests.update', $test->id) }}"
              class="form-horizontal">
            @csrf
            @method('PUT')

            {{-- CATEGORY --}}
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">
                    Category <span class="red">*</span>
                </label>

                <div class="col-sm-9">
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $test->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- TEST NAME --}}
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">
                    Test Name <span class="red">*</span>
                </label>

                <div class="col-sm-9">
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $test->name) }}"
                           required>
                </div>
            </div>

            {{-- METHOD --}}
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">
                    Method
                </label>

                <div class="col-sm-9">
                    <input type="text"
                           name="method"
                           class="form-control"
                           value="{{ old('method', $test->method) }}">
                </div>
            </div>

            {{-- PRICE --}}
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">
                    Price (₹)
                </label>

                <div class="col-sm-9">
                    <input type="number"
                           step="0.01"
                           name="price"
                           class="form-control"
                           value="{{ old('price', $test->price) }}">
                </div>
            </div>

            {{-- STATUS --}}
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">
                    Status
                </label>

                <div class="col-sm-9">
                    <label>
                        <input type="checkbox"
                               name="status"
                               value="1"
                               {{ old('status', $test->status) ? 'checked' : '' }}>
                        <span class="lbl"> Active</span>
                    </label>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">

                    <button type="submit" class="btn btn-success">
                        <i class="ace-icon fa fa-check"></i>
                        Update
                    </button>

                    <a href="{{ route('lab-tests.index') }}" class="btn btn-grey">
                        <i class="ace-icon fa fa-arrow-left"></i>
                        Back
                    </a>

                </div>
            </div>

        </form>

    </div>
</div>

@endsection
