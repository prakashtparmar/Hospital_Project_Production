@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">IPD Admissions</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">IPD Admissions</h4>

    @can('ipd.create')
    <a href="{{ route('ipd.create') }}" class="btn btn-primary btn-sm">
        <i class="ace-icon fa fa-plus"></i> Admit Patient
    </a>
    @endcan
</div>

<div class="row">
    <div class="col-xs-12">

        {{-- SEARCH --}}
        <form method="GET" class="mb-3">
            <input 
                type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Search IPD No, Patient, Doctor..."
                class="form-control">
        </form>

        <div class="table-header">IPD Admission Management</div>

        <div class="table-responsive">
            <table
                class="table table-striped table-bordered table-hover datatable"
                data-page-length="10"
                data-disable-last-column="true">

                <thead>
                    <tr>
                        <th>IPD No</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Ward / Room / Bed</th>
                        <th>Admission Date</th>
                        <th>Status</th>
                        @canany(['ipd.view','ipd.edit','ipd.delete'])
                        <th class="text-center" width="130">Actions</th>
                        @endcanany
                    </tr>
                </thead>

                <tbody>
                    @foreach ($admissions as $i)
                    <tr @if($i->deleted_at) style="background:#ffeaea !important;" @endif>

                        {{-- IPD No --}}
                        <td>{{ $i->ipd_no }}</td>

                        {{-- Patient --}}
                        <td>{{ $i->patient->full_name }}</td>

                        {{-- Doctor --}}
                        <td>{{ $i->doctor->name ?? '---' }}</td>

                        {{-- Ward / Room / Bed --}}
                        <td>
                            {{ $i->ward->name ?? '---' }} /
                            {{ $i->room->room_no ?? '---' }} /
                            {{ $i->bed->bed_no ?? '---' }}
                        </td>

                        {{-- Admission Date --}}
                        <td>
                            {{ $i->admission_date
                                ? \Carbon\Carbon::parse($i->admission_date)->format('d M Y, h:i A')
                                : '---'
                            }}
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($i->deleted_at)
                                <span class="label label-default">Deleted</span>
                            @else
                                @if($i->status == 1)
                                    <span class="label label-success">Admitted</span>
                                @else
                                    <span class="label label-danger">Discharged</span>
                                @endif
                            @endif
                        </td>

                        {{-- ACTIONS --}}
                        @canany(['ipd.view','ipd.edit','ipd.delete'])
                        <td class="text-center">

                            {{-- DESKTOP --}}
                            <div class="hidden-sm hidden-xs action-buttons">

                                {{-- View --}}
                                @can('ipd.view')
                                <a class="blue" href="{{ route('ipd.show', $i->id) }}">
                                    <i class="ace-icon fa fa-eye bigger-130"></i>
                                </a>
                                @endcan

                                {{-- Edit --}}
                                @can('ipd.edit')
                                @if(!$i->deleted_at && $i->status == 1)
                                <a class="green" href="{{ route('ipd.edit', $i->id) }}">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                @endif
                                @endcan

                                {{-- Delete --}}
                                @can('ipd.delete')
                                @if(!$i->deleted_at)
                                <form action="{{ route('ipd.destroy', $i->id) }}"
                                      method="POST"
                                      class="d-inline-block"
                                      onsubmit="return confirm('Delete this IPD Admission?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-link btn-sm red p-0 m-0" style="border:none;">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </button>
                                </form>
                                @endif
                                @endcan
                            </div>

                            {{-- MOBILE --}}
                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-primary dropdown-toggle"
                                            data-toggle="dropdown">
                                        <i class="ace-icon fa fa-cog bigger-110"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right">

                                        {{-- View --}}
                                        @can('ipd.view')
                                        <li>
                                            <a href="{{ route('ipd.show', $i->id) }}">
                                                <span class="blue">
                                                    <i class="ace-icon fa fa-eye bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        @endcan

                                        {{-- Edit --}}
                                        @can('ipd.edit')
                                        @if(!$i->deleted_at && $i->status == 1)
                                        <li>
                                            <a href="{{ route('ipd.edit', $i->id) }}">
                                                <span class="green">
                                                    <i class="ace-icon fa fa-pencil bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @endcan

                                        {{-- Delete --}}
                                        @can('ipd.delete')
                                        @if(!$i->deleted_at)
                                        <li>
                                            <a href="#" onclick="event.preventDefault(); if(confirm('Delete?')) this.nextElementSibling.submit();">
                                                <span class="red">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </span>
                                            </a>
                                            <form action="{{ route('ipd.destroy', $i->id) }}"
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

        {{-- PAGINATION --}}
        <div class="mt-2">
            {{ $admissions->links() }}
        </div>

    </div>
</div>

@endsection
