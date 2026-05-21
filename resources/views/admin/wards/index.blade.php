@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Wards</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Wards</h4>

    @can('wards.create')
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addWardModal">
        <i class="fa fa-plus"></i> Add Ward
    </button>
    @endcan
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade in">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <i class="fa fa-check"></i> {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-header"><strong>Ward List</strong></div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#ID</th>
                    <th>Ward Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($wards as $ward)
                <tr>
                    <td>{{ $ward->id }}</td>
                    <td>{{ $ward->name }}</td>
                    <td>{{ $ward->type ?? '—' }}</td>

                    <td>
                        <span class="badge badge-{{ $ward->status ? 'success' : 'secondary' }}">
                            {{ $ward->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    <td class="text-center">

                        @can('wards.edit')
                        <button class="btn btn-success btn-sm"
                            data-toggle="modal"
                            data-target="#editWardModal{{ $ward->id }}">
                            <i class="fa fa-pencil"></i>
                        </button>
                        @endcan

                        @can('wards.delete')
                        <form action="{{ route('wards.destroy', $ward->id) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this ward?');">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>

                {{-- EDIT MODAL --}}
                <div class="modal fade" id="editWardModal{{ $ward->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Ward</h5>
                                <button class="close" data-dismiss="modal">×</button>
                            </div>

                            <form action="{{ route('wards.update', $ward->id) }}" method="POST">
                                @csrf @method('PUT')

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label>Ward Name</label>
                                        <input type="text" name="name"
                                               value="{{ $ward->name }}"
                                               class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Type</label>
                                        <input type="text" name="type"
                                               value="{{ $ward->type }}"
                                               class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="1" {{ $ward->status ? 'selected':'' }}>Active</option>
                                            <option value="0" {{ !$ward->status ? 'selected':'' }}>Inactive</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-primary">
                                        <i class="fa fa-save"></i> Update
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No wards found.</td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="card-footer">
        {{ $wards->links() }}
    </div>
</div>

{{-- ADD MODAL --}}
<div class="modal fade" id="addWardModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Ward</h5>
                <button class="close" data-dismiss="modal">×</button>
            </div>

            <form action="{{ route('wards.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="form-group">
                        <label>Ward Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Type</label>
                        <input type="text" name="type" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
