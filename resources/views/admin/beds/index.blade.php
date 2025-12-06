@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Beds</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Beds</h4>

    @can('beds.create')
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addBedModal">
        <i class="fa fa-plus"></i> Add Bed
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
    <div class="card-header"><strong>Bed List</strong></div>

    <div class="card-body table-responsive">

        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#ID</th>
                    <th>Bed No</th>
                    <th>Room</th>
                    <th>Ward</th>
                    <th>Occupied</th>
                    <th>Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($beds as $bed)
                <tr>
                    <td>{{ $bed->id }}</td>
                    <td>{{ $bed->bed_no }}</td>

                    <td>{{ $bed->room->room_no ?? '—' }}</td>
                    <td>{{ $bed->room->ward->name ?? '—' }}</td>

                    <td>
                        <span class="badge badge-{{ $bed->is_occupied ? 'danger' : 'success' }}">
                            {{ $bed->is_occupied ? 'Occupied' : 'Available' }}
                        </span>
                    </td>

                    <td>
                        <span class="badge badge-{{ $bed->status ? 'success' : 'secondary' }}">
                            {{ $bed->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    <td class="text-center">

                        @can('beds.edit')
                        <button class="btn btn-success btn-sm"
                                data-toggle="modal"
                                data-target="#editBedModal{{ $bed->id }}">
                            <i class="fa fa-pencil"></i>
                        </button>
                        @endcan

                        @can('beds.delete')
                        <form action="{{ route('beds.destroy', $bed->id) }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this bed?');">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        @endcan

                    </td>

                </tr>

                {{-- EDIT BED MODAL --}}
                <div class="modal fade" id="editBedModal{{ $bed->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Bed</h5>
                                <button class="close" data-dismiss="modal">×</button>
                            </div>

                            <form action="{{ route('beds.update', $bed->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label>Room</label>
                                        <select name="room_id" class="form-control" required>
                                            @foreach($rooms as $r)
                                                <option value="{{ $r->id }}"
                                                    {{ $bed->room_id == $r->id ? 'selected':'' }}>
                                                    Room {{ $r->room_no }} - {{ $r->ward->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Bed No</label>
                                        <input type="text" name="bed_no"
                                               class="form-control"
                                               value="{{ $bed->bed_no }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Occupied</label>
                                        <select name="is_occupied" class="form-control">
                                            <option value="0" {{ !$bed->is_occupied ? 'selected':'' }}>Available</option>
                                            <option value="1" {{ $bed->is_occupied ? 'selected':'' }}>Occupied</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="1" {{ $bed->status ? 'selected':'' }}>Active</option>
                                            <option value="0" {{ !$bed->status ? 'selected':'' }}>Inactive</option>
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
                    <td colspan="7" class="text-center text-muted">No beds found.</td>
                </tr>
                @endforelse

            </tbody>
        </table>

    </div>

    <div class="card-footer">
        {{ $beds->links() }}
    </div>
</div>

{{-- ADD BED MODAL --}}
<div class="modal fade" id="addBedModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Bed</h5>
                <button class="close" data-dismiss="modal">×</button>
            </div>

            <form action="{{ route('beds.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="form-group">
                        <label>Room</label>
                        <select name="room_id" class="form-control" required>
                            <option value="">-- Select Room --</option>
                            @foreach($rooms as $r)
                                <option value="{{ $r->id }}">
                                    Room {{ $r->room_no }} - {{ $r->ward->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Bed No</label>
                        <input type="text" name="bed_no" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Occupied</label>
                        <select name="is_occupied" class="form-control">
                            <option value="0">Available</option>
                            <option value="1">Occupied</option>
                        </select>
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
                    <button class="btn btn-primary">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
