@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Patients</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Patients</h4>

    @can('patients.create')
    <a href="{{ route('patients.create') }}" class="btn btn-primary btn-sm">
        <i class="ace-icon fa fa-plus"></i> Add Patient
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

<div class="row">
    <div class="col-xs-12">

        {{-- Search --}}
        <form method="GET" class="mb-3">
            <input 
                type="text" 
                class="form-control" 
                name="search" 
                value="{{ $search }}" 
                placeholder="Search patient..."
            >
        </form>

        <div class="table-header">Patients Management</div>

        <div class="table-responsive">
            <table 
                id="dynamic-table"
                class="table table-striped table-bordered table-hover datatable"
                data-page-length="10"
                data-disable-last-column="true">

                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Registered</th>

                        @canany(['patients.view','patients.edit','patients.delete'])
                        <th class="text-center" width="170">Actions</th>
                        @endcanany
                    </tr>
                </thead>

                <tbody>
                    @foreach($patients as $p)
                    <tr>

                        <td>{{ $p->patient_id }}</td>

                        <td>{{ $p->full_name }}</td>

                        <td>{{ ucfirst($p->gender) }}</td>

                        <td>{{ $p->phone ?? '---' }}</td>

                        <td>{{ $p->department->name ?? '---' }}</td>

                        <td>
                            @if($p->status)
                                <span class="label label-success">Active</span>
                            @else
                                <span class="label label-danger">Inactive</span>
                            @endif
                        </td>

                        <td>{{ $p->created_at? $p->created_at->format('d M, Y') : '---' }}</td>

                        @canany(['patients.view','patients.edit','patients.delete'])
                        <td class="text-center">

                            <div class="hidden-sm hidden-xs action-buttons">

                                {{-- View --}}
                                @can('patients.view')
                                <a class="blue" href="{{ route('patients.show', $p->id) }}">
                                    <i class="ace-icon fa fa-eye bigger-130"></i>
                                </a>
                                @endcan

                                {{-- Edit --}}
                                @can('patients.edit')
                                <a class="green" href="{{ route('patients.edit', $p->id) }}">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                @endcan

                                {{-- Delete --}}
                                @can('patients.delete')
                                <form action="{{ route('patients.destroy', $p->id) }}"
                                      method="POST"
                                      class="d-inline-block"
                                      onsubmit="return confirm('Delete this patient?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-link btn-sm red p-0 m-0" style="border:none;background:none;">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </button>
                                </form>
                                @endcan

                            </div>

                            {{-- MOBILE ACTION DROPDOWN --}}
                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right">

                                        {{-- View --}}
                                        @can('patients.view')
                                        <li>
                                            <a href="{{ route('patients.show', $p->id) }}" title="View">
                                                <span class="blue">
                                                    <i class="ace-icon fa fa-eye bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        @endcan

                                        {{-- Edit --}}
                                        @can('patients.edit')
                                        <li>
                                            <a href="{{ route('patients.edit', $p->id) }}" title="Edit">
                                                <span class="green">
                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        @endcan

                                        {{-- Delete --}}
                                        @can('patients.delete')
                                        <li>
                                            <a href="#" onclick="event.preventDefault(); if(confirm('Delete this patient?')) this.nextElementSibling.submit();" title="Delete">
                                                <span class="red">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </span>
                                            </a>
                                            <form action="{{ route('patients.destroy', $p->id) }}" method="POST" style="display:none;">
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
                    @endforeach
                </tbody>

            </table>
        </div>

        <div class="mt-2">
            {{ $patients->links() }}
        </div>

    </div>
</div>

@endsection
