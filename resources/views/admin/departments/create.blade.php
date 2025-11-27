@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header"><h4>Create Department</h4></div>

    <div class="card-body">
        <form action="{{ route('departments.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Code</label>
                <input name="code" class="form-control">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <button class="btn btn-success">Create</button>

        </form>
    </div>
</div>
@endsection
