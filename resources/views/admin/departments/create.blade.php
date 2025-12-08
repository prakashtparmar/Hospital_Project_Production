@extends('layouts.app')

@section('breadcrumbs')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('departments.index') }}">Departments</a>
            </li>
            <li class="active">Create Department</li>
        </ul>
    </div>
@endsection

@section('content')

    <div class="page-header mb-3">
        <h4 class="page-title">Create Department</h4>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('departments.store') }}" method="POST">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label">Department Name</label>
                            <input name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Code (AUTO / MANUAL) --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Department Code
                                <small class="text-muted">(Auto: DEPT-001, DEPT-002… | Optional manual)</small>
                            </label>
                            <input name="code" class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code') }}" maxlength="10">
                            @error('code')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>


                        {{-- Status --}}
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success mt-3">
                            <i class="fa fa-check"></i> Create Department
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>

@endsection