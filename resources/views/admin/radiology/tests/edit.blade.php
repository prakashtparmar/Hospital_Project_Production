@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('radiology-tests.index') }}">Radiology Tests</a>
        </li>
        <li class="active">Edit Test</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">Edit Radiology Test</h4>
</div>

<div class="row">
    <div class="col-xs-12 col-md-6">

        <form method="POST" action="{{ route('radiology-tests.update',$test->id) }}" class="form-horizontal">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="control-label">Category</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ $test->category_id == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="control-label">Test Name</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $test->name) }}"
                    required>
            </div>

            <div class="form-group">
                <label class="control-label">Modality</label>
                <input
                    type="text"
                    name="modality"
                    class="form-control"
                    value="{{ old('modality', $test->modality) }}"
                    required>
            </div>

            <div class="form-group">
                <label class="control-label">Price</label>
                <input
                    type="number"
                    step="0.01"
                    name="price"
                    class="form-control"
                    value="{{ old('price', $test->price) }}"
                    required>
            </div>

            <div class="form-group">
                @can('radiology-tests.edit')
                <button type="submit" class="btn btn-success">
                    <i class="ace-icon fa fa-save"></i> Update
                </button>
                @endcan

                <a href="{{ route('radiology-tests.index') }}" class="btn btn-default">
                    <i class="ace-icon fa fa-arrow-left"></i> Back
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
