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
                    <input type="hidden" name="status" value="0">
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

@can('lab-parameters.view')
<div class="row">
    <div class="col-xs-12">
        <div class="space-16"></div>
        <div class="widget-box">
            <div class="widget-header widget-header-small">
                <h5 class="widget-title lighter">Test Parameters</h5>
                <div class="widget-toolbar">
                    <a href="{{ route('lab.parameters.index', $test->id) }}" class="btn btn-xs btn-primary">
                        Manage All Parameters
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main no-padding">
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Reference Range</th>
                                @canany(['lab-parameters.edit','lab-parameters.delete'])
                                    <th class="text-center">Actions</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($test->parameters as $parameter)
                                <tr>
                                    <td>{{ $parameter->id }}</td>
                                    <td>{{ $parameter->name }}</td>
                                    <td>{{ $parameter->unit ?? '---' }}</td>
                                    <td>{{ $parameter->reference_range ?? '---' }}</td>
                                    @canany(['lab-parameters.edit','lab-parameters.delete'])
                                    <td class="text-center">
                                        @can('lab-parameters.edit')
                                        <a class="green" href="{{ route('lab.parameters.edit', [$test->id, $parameter->id]) }}">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                        @endcan

                                        @can('lab-parameters.delete')
                                        <form action="{{ route('lab.parameters.destroy', [$test->id, $parameter->id]) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this parameter?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-link red p-0">
                                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                    @endcanany
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        No parameters defined for this test yet.
                                        @can('lab-parameters.create')
                                            <a href="{{ route('lab.parameters.create', $test->id) }}">Add Parameters</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan

@endsection
