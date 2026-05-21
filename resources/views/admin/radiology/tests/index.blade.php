@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Radiology Tests</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Radiology Tests</h4>

    @can('radiology-tests.create')
    <a href="{{ route('radiology-tests.create') }}" class="btn btn-primary btn-sm">
        <i class="ace-icon fa fa-plus"></i> Add Test
    </a>
    @endcan
</div>

<div class="row">
    <div class="col-xs-12">

        <div class="table-header">Radiology Tests Management</div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Modality</th>
                        <th>Price</th>
                        @can('radiology-tests.edit')
                        <th class="text-center">Actions</th>
                        @endcan
                    </tr>
                </thead>

                <tbody>
                    @foreach($tests as $test)
                    <tr>
                        <td>{{ $test->id }}</td>
                        <td>{{ $test->category->name }}</td>
                        <td>{{ $test->name }}</td>
                        <td>{{ $test->modality }}</td>
                        <td>{{ number_format($test->price,2) }}</td>

                        @can('radiology-tests.edit')
                        <td class="text-center">
                            <a class="green" href="{{ route('radiology-tests.edit',$test->id) }}">
                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
