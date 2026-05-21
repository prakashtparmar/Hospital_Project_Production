@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Departments</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Departments</h4>

    @can('departments.create')
    <a href="{{ route('departments.create') }}" class="btn btn-primary btn-sm">
        <i class="ace-icon fa fa-plus"></i> Add Department
    </a>
    @endcan
</div>

<div class="row">
    <div class="col-xs-12">

        <div class="table-header">Departments Management</div>

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
                        <th>Code</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        @canany(['departments.edit','departments.delete'])
                        <th class="text-center" width="170">Actions</th>
                        @endcanany
                    </tr>
                </thead>

                <tbody>
                    @foreach ($departments as $dep)
                    <tr @if($dep->deleted_at) style="background:#ffe9e9;" @endif>

                        <td>{{ $dep->id }}</td>

                        <td>
                            {{ $dep->name }}
                            @if($dep->deleted_at)
                                <span class="label label-danger">Deleted</span>
                            @endif
                        </td>

                        <td>{{ $dep->code ?? '---' }}</td>

                        <td>{{ $dep->description ? Str::limit($dep->description, 40) : '---' }}</td>

                        <td>
                            @if($dep->deleted_at)
                                <span class="label label-default">Deleted</span>
                            @else
                                @if($dep->status)
                                    <span class="label label-success">Active</span>
                                @else
                                    <span class="label label-danger">Inactive</span>
                                @endif
                            @endif
                        </td>

                        <td>{{ $dep->created_at ? $dep->created_at->format('d M, Y') : '---' }}</td>
                        <td>{{ $dep->updated_at ? $dep->updated_at->format('d M, Y') : '---' }}</td>

                        @canany(['departments.edit','departments.delete'])
                        <td class="text-center">

                            <div class="hidden-sm hidden-xs action-buttons">

                                {{-- Edit (only for active departments) --}}
                                @can('departments.edit')
                                @if(!$dep->deleted_at)
                                <a class="green" href="{{ route('departments.edit', $dep->id) }}">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                @endif
                                @endcan

                                {{-- Soft Delete --}}
                                @can('departments.delete')
                                @if(!$dep->deleted_at)
                                <form action="{{ route('departments.destroy', $dep->id) }}"
                                      method="POST"
                                      class="d-inline-block"
                                      onsubmit="return confirm('Delete this department?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-link btn-sm red p-0 m-0" style="border:none;background:none;">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </button>
                                </form>
                                @endif
                                @endcan

                                {{-- Restore --}}
                                @if($dep->deleted_at)
                                <form action="{{ route('departments.restore', $dep->id) }}"
                                      method="POST"
                                      class="d-inline-block"
                                      onsubmit="return confirm('Restore this department?');">
                                    @csrf
                                    <button class="btn btn-warning btn-sm">
                                        <i class="fa fa-undo"></i>
                                    </button>
                                </form>
                                @endif

                                {{-- Permanent Delete --}}
                                @if($dep->deleted_at)
                                <form action="{{ route('departments.force-delete', $dep->id) }}"
                                      method="POST"
                                      class="d-inline-block"
                                      onsubmit="return confirm('Permanently delete this department? This cannot be undone!');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </form>
                                @endif

                            </div>

                            {{-- MOBILE --}}
                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right">

                                        {{-- Edit --}}
                                        @can('departments.edit')
                                        @if(!$dep->deleted_at)
                                        <li>
                                            <a href="{{ route('departments.edit', $dep->id) }}" title="Edit">
                                                <span class="green">
                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @endcan

                                        {{-- Soft Delete --}}
                                        @can('departments.delete')
                                        @if(!$dep->deleted_at)
                                        <li>
                                            <a href="#" onclick="event.preventDefault(); if(confirm('Delete this department?')) this.nextElementSibling.submit();" title="Delete">
                                                <span class="red">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </span>
                                            </a>
                                            <form action="{{ route('departments.destroy', $dep->id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </li>
                                        @endif
                                        @endcan

                                        {{-- Restore --}}
                                        @if($dep->deleted_at)
                                        <li>
                                            <a href="#" onclick="event.preventDefault(); this.nextElementSibling.submit();" title="Restore">
                                                <span class="orange">
                                                    <i class="fa fa-undo bigger-120"></i>
                                                </span>
                                            </a>
                                            <form action="{{ route('departments.restore', $dep->id) }}" method="POST" style="display:none;">
                                                @csrf
                                            </form>
                                        </li>
                                        @endif

                                        {{-- Permanent Delete --}}
                                        @if($dep->deleted_at)
                                        <li>
                                            <a href="#" onclick="event.preventDefault(); if(confirm('Permanently delete this department?')) this.nextElementSibling.submit();" title="Permanent Delete">
                                                <span class="red">
                                                    <i class="fa fa-times bigger-120"></i>
                                                </span>
                                            </a>
                                            <form action="{{ route('departments.force-delete', $dep->id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </li>
                                        @endif

                                    </ul>

                                </div>
                            </div>

                        </td>
                        @endcanany

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
