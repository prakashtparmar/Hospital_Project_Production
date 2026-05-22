@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Lab Tests</li>
    </ul>
</div>
@endsection

@section('content')

{{-- Page Header --}}
<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Lab Tests</h4>

    @can('lab-tests.create')
    <a href="{{ route('lab-tests.create') }}" class="btn btn-primary btn-sm">
        <i class="ace-icon fa fa-plus"></i> Add Test
    </a>
    @endcan
</div>

{{-- Access control --}}
@cannot('lab-tests.view')
    <div class="alert alert-danger">
        You do not have permission to view lab tests.
    </div>
@else

<div class="row">
    <div class="col-xs-12">

        <div class="table-header">Lab Tests Management</div>

        <div class="table-responsive">
            <table
                class="table table-striped table-bordered table-hover datatable"
                data-page-length="10">

                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Parameters</th>
                        <th>Method</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Created</th>

                        @canany(['lab-tests.edit','lab-tests.delete','lab-parameters.view'])
                        <th class="text-center" width="180">Actions</th>
                        @endcanany
                    </tr>
                </thead>

                <tbody>
                    @foreach($tests as $test)
                    <tr @if($test->deleted_at) style="background:#ffe9e9;" @endif>

                        <td>{{ $test->id }}</td>

                        <td>
                            {{ $test->name }}
                            @if($test->deleted_at)
                                <span class="label label-danger">Deleted</span>
                            @endif
                        </td>

                        <td>{{ optional($test->category)->name ?? '---' }}</td>
                        <td>
                            {{ $test->parameters_count ?? $test->parameters->count() }}
                            @can('lab-parameters.view')
                                <a href="{{ route('lab.parameters.index', $test->id) }}" title="Manage Parameters">
                                    <i class="ace-icon fa fa-list text-primary" style="margin-left:6px"></i>
                                </a>
                            @endcan
                        </td>
                        <td>{{ $test->method ?? '---' }}</td>
                        <td>₹ {{ number_format((float)$test->price,2) }}</td>

                        <td>
                            @if($test->status)
                                <span class="label label-success">Active</span>
                            @else
                                <span class="label label-danger">Inactive</span>
                            @endif
                        </td>

                        <td>{{ $test->created_at?->format('d M, Y') }}</td>

                        @canany(['lab-tests.edit','lab-tests.delete','lab-parameters.view'])
                        <td class="text-center">

                            {{-- PARAMETERS --}}
                            @can('lab-parameters.view')
                            <a class="blue" href="{{ route('lab.parameters.index', $test->id) }}" title="Manage Parameters">
                                <i class="ace-icon fa fa-list bigger-130"></i>
                            </a>
                            @endcan

                            {{-- EDIT --}}
                            @can('lab-tests.edit')
                            <a class="green" href="{{ route('lab-tests.edit',$test->id) }}">
                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>
                            @endcan

                            {{-- DELETE --}}
                            @can('lab-tests.delete')
                            <form action="{{ route('lab-tests.destroy',$test->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete this lab test?')">
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
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

@endcannot
@endsection
