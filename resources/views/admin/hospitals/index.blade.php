{{-- resources/views/admin/hospitals/index.blade.php --}}
@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Hospitals</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Hospitals</h4>

    @can('hospitals.create')
    <a href="{{ route('admin.hospitals.create') }}" class="btn btn-primary btn-sm">
        <i class="ace-icon fa fa-plus"></i> Add Hospital
    </a>
    @endcan
</div>


@if(session('success'))
<div class="alert alert-success alert-dismissible fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <i class="ace-icon fa fa-check"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <i class="ace-icon fa fa-times"></i>
    {{ session('error') }}
</div>
@endif


<div class="row">
    <div class="col-xs-12">

        <div class="table-header">Hospitals Management</div>

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
                        <th>Contact</th>
                        <th>Domain</th>
                        @canany(['hospitals.edit', 'hospitals.delete'])
                        <th class="text-center" width="170">Actions</th>
                        @endcanany
                    </tr>
                </thead>

                <tbody>
                    @forelse ($hospitals as $hospital)
                    <tr>
                        <td>{{ $hospital->id }}</td>

                        <td>{{ data_get($hospital->data, 'name', '---') }}</td>

                        <td>{{ data_get($hospital->data, 'contact', '---') }}</td>

                        <td>{{ optional($hospital->domains->first())->domain ?? '---' }}</td>

                        @canany(['hospitals.edit', 'hospitals.delete'])
                        <td class="text-center">
                            <div class="hidden-sm hidden-xs action-buttons">

                                @can('hospitals.edit')
                                <a class="green" href="{{ route('admin.hospitals.edit', $hospital->id) }}">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                @endcan

                                @can('hospitals.delete')
                                <form action="{{ route('admin.hospitals.destroy', $hospital->id) }}"
                                      method="POST"
                                      class="d-inline-block"
                                      onsubmit="return confirm('Delete this hospital?');">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-link btn-sm red p-0 m-0" style="border:none;background:none;">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>

                            {{-- MOBILE ACTIONS --}}
                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right">

                                        @can('hospitals.edit')
                                        <li>
                                            <a href="{{ route('admin.hospitals.edit', $hospital->id) }}" title="Edit">
                                                <span class="green">
                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        @endcan

                                        @can('hospitals.delete')
                                        <li>
                                            <a href="#" onclick="event.preventDefault(); if(confirm('Delete this hospital?')) this.nextElementSibling.submit();" title="Delete">
                                                <span class="red">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </span>
                                            </a>
                                            <form action="{{ route('admin.hospitals.destroy', $hospital->id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </li>
                                        @endcan
                                    </ul>

                                </div>
                            </div>

                        </td>
                        @endcanany
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No hospitals found.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
