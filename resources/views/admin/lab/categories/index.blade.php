@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Lab Categories</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Lab Categories</h4>

    @can('lab-test-categories.create')
    <a href="{{ route('lab-test-categories.create') }}" class="btn btn-primary btn-sm">
        <i class="ace-icon fa fa-plus"></i> Add Category
    </a>
    @endcan
</div>

<div class="row">
    <div class="col-xs-12">

        <div class="table-header">Lab Categories Management</div>

        <div class="table-responsive">
            <table
                id="dynamic-table"
                class="table table-striped table-bordered table-hover datatable"
                data-page-length="10"
                data-disable-last-column="true">

                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        @can('lab-test-categories.edit')
                        <th class="text-center" width="120">Actions</th>
                        @endcan
                    </tr>
                </thead>

                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>

                        <td>{{ $category->name }}</td>

                        <td>{{ $category->created_at?->format('d M, Y') ?? '---' }}</td>
                        <td>{{ $category->updated_at?->format('d M, Y') ?? '---' }}</td>

                        @can('lab-test-categories.edit')
                        <td class="text-center">

                            <div class="hidden-sm hidden-xs action-buttons">
                                <a class="green" href="{{ route('lab-test-categories.edit', $category->id) }}">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                            </div>

                            {{-- MOBILE --}}
                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right">
                                        <li>
                                            <a href="{{ route('lab-test-categories.edit', $category->id) }}" title="Edit">
                                                <span class="green">
                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>

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
