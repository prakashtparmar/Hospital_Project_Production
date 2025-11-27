@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header"><h4>Edit Department</h4></div>

    <div class="card-body">
        <form action="{{ route('departments.update', $department->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Name</label>
                <input name="name" value="{{ $department->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Code</label>
                <input name="code" value="{{ $department->code }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" @if($department->status) selected @endif>Active</option>
                    <option value="0" @if(!$department->status) selected @endif>Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ $department->description }}</textarea>
            </div>

            <button class="btn btn-success">Update</button>

        </form>
    </div>
</div>
@endsection
