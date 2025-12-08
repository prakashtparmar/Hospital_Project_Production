@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">OPD Visits</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">OPD Visits</h4>

    @can('opd.create')
    <a href="{{ route('opd.create') }}" class="btn btn-primary btn-sm">
        <i class="ace-icon fa fa-plus"></i> Add OPD Visit
    </a>
    @endcan
</div>

<div class="row">
    <div class="col-xs-12">

        {{-- Search --}}
        <form method="GET" class="mb-3">
            <input 
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Search OPD No, Patient, Doctor..."
                class="form-control">
        </form>

        <div class="table-header">OPD Visit Management</div>

        <div class="table-responsive">
            <table 
                id="dynamic-table"
                class="table table-striped table-bordered table-hover datatable"
                data-page-length="10"
                data-disable-last-column="true">

                <thead>
                    <tr>
                        <th>OPD No</th>
                        <th>Patient</th>
                        <th>Visit Date</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Status</th>
                        @canany(['opd.view','opd.edit','opd.delete'])
                        <th class="text-center" width="150">Actions</th>
                        @endcanany
                    </tr>
                </thead>

                <tbody>
                    @foreach ($visits as $v)
                    <tr @if($v->deleted_at) style="background:#ffeaea !important;" @endif>

                        {{-- OPD No --}}
                        <td>{{ $v->opd_no }}</td>

                        {{-- Patient Name --}}
                        <td>{{ $v->patient->full_name }}</td>

                        {{-- Visit Date --}}
                        <td>
                            {{ $v->visit_date 
                                ? \Carbon\Carbon::parse($v->visit_date)->format('d M, Y')
                                : '---' 
                            }}
                        </td>

                        {{-- Doctor --}}
                        <td>{{ $v->doctor->name ?? '---' }}</td>

                        {{-- Department --}}
                        <td>{{ $v->department->name ?? '---' }}</td>

                        {{-- Status --}}
                        <td>
                            @if($v->deleted_at)
                                <span class="label label-default">Deleted</span>
                            @else
                                @if($v->status)
                                    <span class="label label-success">Active</span>
                                @else
                                    <span class="label label-danger">Inactive</span>
                                @endif
                            @endif
                        </td>

                        {{-- ACTIONS --}}
                        @canany(['opd.view','opd.edit','opd.delete'])
                        <td class="text-center">

                            {{-- DESKTOP ACTIONS --}}
                            <div class="hidden-sm hidden-xs action-buttons">

                                {{-- VIEW --}}
                                @can('opd.view')
                                <a class="blue" href="{{ route('opd.show', $v->id) }}">
                                    <i class="ace-icon fa fa-eye bigger-130"></i>
                                </a>
                                @endcan

                                {{-- EDIT --}}
                                @can('opd.edit')
                                @if(!$v->deleted_at)
                                <a class="green" href="{{ route('opd.edit', $v->id) }}">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                @endif
                                @endcan

                                {{-- DELETE --}}
                                @can('opd.delete')
                                @if(!$v->deleted_at)
                                <form action="{{ route('opd.destroy', $v->id) }}"
                                      method="POST"
                                      class="d-inline-block"
                                      onsubmit="return confirm('Delete this OPD record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        class="btn btn-link btn-sm red p-0 m-0"
                                        style="border:none;background:none;">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </button>
                                </form>
                                @endif
                                @endcan

                            </div>

                            {{-- MOBILE ACTIONS --}}
                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <i class="ace-icon fa fa-cog bigger-110"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right">

                                        {{-- VIEW --}}
                                        @can('opd.view')
                                        <li>
                                            <a href="{{ route('opd.show', $v->id) }}">
                                                <span class="blue">
                                                    <i class="ace-icon fa fa-eye bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        @endcan

                                        {{-- EDIT --}}
                                        @can('opd.edit')
                                        @if(!$v->deleted_at)
                                        <li>
                                            <a href="{{ route('opd.edit', $v->id) }}">
                                                <span class="green">
                                                    <i class="ace-icon fa fa-pencil bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @endcan

                                        {{-- DELETE --}}
                                        @can('opd.delete')
                                        @if(!$v->deleted_at)
                                        <li>
                                            <a href="#" onclick="event.preventDefault(); if(confirm('Delete?')) this.nextElementSibling.submit();">
                                                <span class="red">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </span>
                                            </a>
                                            <form action="{{ route('opd.destroy', $v->id) }}"
                                                  method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </li>
                                        @endif
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
            {{ $visits->links() }}
        </div>

    </div>
</div>

@endsection
