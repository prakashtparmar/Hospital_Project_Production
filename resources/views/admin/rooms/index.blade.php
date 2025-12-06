@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="active">Rooms</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h4 class="page-title">Rooms</h4>

    @can('rooms.create')
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addRoomModal">
        <i class="fa fa-plus"></i> Add Room
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
    <div class="card-header"><strong>Room List</strong></div>

    <div class="card-body table-responsive">

        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#ID</th>
                    <th>Room No</th>
                    <th>Ward</th>
                    <th>Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td>{{ $room->room_no }}</td>
                    <td>{{ $room->ward->name ?? '—' }}</td>

                    <td>
                        <span class="badge badge-{{ $room->status ? 'success':'danger' }}">
                            {{ $room->status ? 'Active':'Inactive' }}
                        </span>
                    </td>

                    <td class="text-center">

                        @can('rooms.edit')
                        <button class="btn btn-success btn-sm"
                                data-toggle="modal"
                                data-target="#editRoomModal{{ $room->id }}">
                            <i class="fa fa-pencil"></i>
                        </button>
                        @endcan

                        @can('rooms.delete')
                        <form action="{{ route('rooms.destroy', $room->id) }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this room?');">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        @endcan

                    </td>
                </tr>

                {{-- EDIT ROOM MODAL --}}
                <div class="modal fade" id="editRoomModal{{ $room->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Room</h5>
                                <button class="close" data-dismiss="modal">×</button>
                            </div>

                            <form action="{{ route('rooms.update', $room->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label>Ward</label>
                                        <select name="ward_id" class="form-control" required>
                                            @foreach($wards as $w)
                                                <option value="{{ $w->id }}"
                                                    {{ $room->ward_id == $w->id ? 'selected':'' }}>
                                                    {{ $w->name }} ({{ $w->type ?? 'General' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Room No</label>
                                        <input type="text" name="room_no"
                                               class="form-control"
                                               value="{{ $room->room_no }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="1" {{ $room->status ? 'selected':'' }}>Active</option>
                                            <option value="0" {{ !$room->status ? 'selected':'' }}>Inactive</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No rooms found.</td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    <div class="card-footer">
        {{ $rooms->links() }}
    </div>
</div>

{{-- ADD ROOM MODAL --}}
<div class="modal fade" id="addRoomModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Room</h5>
                <button class="close" data-dismiss="modal">×</button>
            </div>

            <form action="{{ route('rooms.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="form-group">
                        <label>Ward</label>
                        <select name="ward_id" class="form-control" required>
                            <option value="">-- Select Ward --</option>
                            @foreach($wards as $w)
                                <option value="{{ $w->id }}">{{ $w->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Room No</label>
                        <input type="text" name="room_no" class="form-control" required>
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
