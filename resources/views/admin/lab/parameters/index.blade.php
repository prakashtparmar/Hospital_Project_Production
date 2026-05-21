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
        <li class="active">{{ $lab_test->name }} Parameters</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Parameters for {{ $lab_test->name }}</h4>

    <div>
        @can('lab-parameters.create')
        <a href="{{ route('lab.parameters.create', $lab_test->id) }}" class="btn btn-primary btn-sm">
            <i class="ace-icon fa fa-plus"></i> Add Parameters
        </a>
        @endcan

        <a href="{{ route('lab-tests.index') }}" class="btn btn-default btn-sm">
            <i class="ace-icon fa fa-arrow-left"></i> Back to Lab Tests
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="table-header">Lab Test Parameters</div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover datatable" data-page-length="10">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Unit</th>
                        <th>Reference Range</th>
                        <th>Created</th>
                        <th class="text-center" width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($parameters as $parameter)
                    <tr>
                        <td>{{ $parameter->id }}</td>
                        <td>{{ $parameter->name }}</td>
                        <td>{{ $parameter->unit ?? '---' }}</td>
                        <td>{{ $parameter->reference_range ?? '---' }}</td>
                        <td>{{ $parameter->created_at?->format('d M, Y') }}</td>
                        <td class="text-center">
                            @can('lab-parameters.edit')
                            <a class="green" href="{{ route('lab.parameters.edit', [$lab_test->id, $parameter->id]) }}">
                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>
                            @endcan

                            @can('lab-parameters.delete')
                            <form action="{{ route('lab.parameters.destroy', [$lab_test->id, $parameter->id]) }}"
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No parameters found for this test.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $parameters->links() }}
    </div>
</div>

@endsection
