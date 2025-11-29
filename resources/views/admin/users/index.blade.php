@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Users</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Users</h4>

    @can('users.create')
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
        <i class="ace-icon fa fa-plus"></i> Add User
    </a>
    @endcan
</div>

{{-- Success Message --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <i class="ace-icon fa fa-check"></i>
    {{ session('success') }}
</div>
@endif

<div class="row">
    <div class="col-xs-12">

        <div class="table-header">
            Users Management
        </div>

        <div class="table-responsive">

            <table 
                id="dynamic-table" 
                class="table table-striped table-bordered table-hover datatable"
                data-page-length="10"
                data-disable-last-column="true">

                <thead>
                    <tr>
                        <th>ID</th>

                        {{-- NEW Photo Column --}}
                        <th>Photo</th>

                        <th>Name</th>
                        <th>Email</th>
                        <th>Email Verified</th>
                        <th>Status</th>
                        <th>Role(s)</th>
                        <th>Created At</th>
                        <th>Last Login IP</th>
                        <th>Last Login</th>
                        <th>Device</th>
                        <th class="text-center" width="150">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                    <tr>

                        <td>{{ $user->id }}</td>

                        {{-- USER PHOTO --}}
                        <td>
                            <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('ace/assets/images/avatars/profile-pic.jpg') }}"
                                 alt="User Image"
                                 style="width:45px;height:45px;border-radius:50%;object-fit:cover;">
                        </td>

                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>

                        <td>
                            @if($user->email_verified_at)
                                <span class="label label-success">Verified</span>
                            @else
                                <span class="label label-warning">Pending</span>
                            @endif
                        </td>

                        <td>
                            @if($user->is_active)
                                <span class="label label-success">Active</span>
                            @else
                                <span class="label label-danger">Inactive</span>
                            @endif
                        </td>

                        <td>
                            @foreach ($user->roles as $role)
                                <span class="label label-info">{{ $role->name }}</span>
                            @endforeach
                        </td>

                        <td>{{ $user->created_at->format('d M Y') }}</td>

                        <td>{{ $user->ip_address ?? '---' }}</td>

                        <td>
                            @if($user->last_activity)
                                {{ \Carbon\Carbon::createFromTimestamp($user->last_activity)->diffForHumans() }}
                            @else
                                ---
                            @endif
                        </td>

                        <td>
                            @if($user->user_agent)
                                {{ substr($user->user_agent, 0, 25) }}...
                            @else
                                ---
                            @endif
                        </td>

                        <td class="text-center">

                            <div class="hidden-sm hidden-xs action-buttons">
                                @can('users.edit')
                                <a class="green" href="{{ route('users.edit', $user->id) }}">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                @endcan

                                @can('users.delete')
                                <form action="{{ route('users.destroy', $user->id) }}"
                                      method="POST" class="d-inline-block"
                                      onsubmit="return confirm('Delete user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-link btn-sm red p-0 m-0"
                                            style="border:none;background:none;">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>

                            {{-- Mobile --}}
                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-primary dropdown-toggle"
                                            data-toggle="dropdown">
                                        <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right">

                                        @can('users.edit')
                                        <li>
                                            <a href="{{ route('users.edit', $user->id) }}"
                                               class="tooltip-success"
                                               title="Edit">
                                                <span class="green">
                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                        @endcan

                                        @can('users.delete')
                                        <li>
                                            <a href="#"
                                               class="tooltip-error"
                                               onclick="event.preventDefault(); if(confirm('Delete user?')) this.nextElementSibling.submit();"
                                               title="Delete">
                                                <span class="red">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </span>
                                            </a>

                                            <form action="{{ route('users.destroy', $user->id) }}"
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
