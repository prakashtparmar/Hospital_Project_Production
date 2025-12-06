@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Roles</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Roles</h4>

    @can('roles.create')
    <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
        <i class="ace-icon fa fa-plus"></i> Add Role
    </a>
    @endcan
</div>

<div class="row">
    <div class="col-xs-12">

        <div class="table-header">
            Roles & Assigned Permissions
        </div>

        <div class="table-responsive">
            
            <!-- DataTable Enabled -->
            <table 
                class="table table-striped table-bordered table-hover datatable"
                data-page-length="10"
                data-disable-last-column="true">

                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Permissions</th>
                        <th class="text-center" width="150">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <td class="fw-bold">{{ $role->name }}</td>

                        <td>
                            @if($role->permissions->count())
                                @foreach ($role->permissions as $permission)
                                    <span class="label label-info arrowed-right arrowed">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-muted">No permissions assigned</span>
                            @endif
                        </td>

                        <td class="text-center">

                            {{-- Desktop Buttons --}}
                            <div class="hidden-sm hidden-xs action-buttons">

                                @can('roles.edit')
                                <a class="green" href="{{ route('roles.edit', $role->id) }}">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                @endcan

                                @can('roles.delete')
                                <form action="{{ route('roles.destroy', $role->id) }}"
                                      method="POST"
                                      class="d-inline-block"
                                      onsubmit="return confirm('Delete this role?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-link btn-sm red p-0"
                                            style="border:none;background:none;">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>

                            {{-- Mobile Dropdown --}}
                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">

                                    <button class="btn btn-minier btn-primary dropdown-toggle"
                                            data-toggle="dropdown">
                                        <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">

                                        @can('roles.edit')
                                        <li>
                                            <a href="{{ route('roles.edit', $role->id) }}"
                                               class="tooltip-success"
                                               title="Edit Role">
                                                <span class="green">
                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        @endcan

                                        @can('roles.delete')
                                        <li>
                                            <a href="#"
                                               class="tooltip-error"
                                               title="Delete"
                                               onclick="event.preventDefault(); if(confirm('Delete this role?')) this.nextElementSibling.submit();">
                                                <span class="red">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </span>
                                            </a>

                                            <form action="{{ route('roles.destroy', $role->id) }}"
                                                  method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </li>
                                        @endcan
                                        
                                    </ul>

                                </div>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection
