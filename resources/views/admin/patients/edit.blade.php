@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header"><h4>Edit Patient: {{ $patient->first_name }} {{ $patient->last_name }}</h4></div>

    <div class="card-body">
        <form method="POST" action="{{ route('patients.update', $patient->id) }}">
            @csrf
            @method('PUT') {{-- Required for update route --}}

            <div class="row">

                {{-- First Name --}}
                <div class="col-md-6 mb-3">
                    <label for="first_name">First Name</label>
                    <input name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $patient->first_name) }}" required>
                    @error('first_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Last Name --}}
                <div class="col-md-6 mb-3">
                    <label for="last_name">Last Name</label>
                    <input name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $patient->last_name) }}">
                    @error('last_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Gender --}}
                <div class="col-md-4 mb-3">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="form-control">
                        @php $gender = old('gender', $patient->gender); @endphp
                        <option value="Male" {{ $gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $gender == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ $gender == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Age --}}
                <div class="col-md-4 mb-3">
                    <label for="age">Age</label>
                    <input name="age" id="age" type="number" class="form-control" value="{{ old('age', $patient->age) }}">
                    @error('age') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Phone --}}
                <div class="col-md-4 mb-3">
                    <label for="phone">Phone</label>
                    <input name="phone" id="phone" class="form-control" value="{{ old('phone', $patient->phone) }}">
                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Email --}}
                <div class="col-md-6 mb-3">
                    <label for="email">Email</label>
                    <input name="email" id="email" type="email" class="form-control" value="{{ old('email', $patient->email) }}">
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Department --}}
                <div class="col-md-6 mb-3">
                    <label for="department_id">Department</label>
                    <select name="department_id" id="department_id" class="form-control">
                        <option value="">-- Select --</option>
                        @foreach ($departments as $d)
                            <option value="{{ $d->id }}" {{ old('department_id', $patient->department_id) == $d->id ? 'selected' : '' }}>
                                {{ $d->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Address --}}
                <div class="col-12 mb-3">
                    <label for="address">Address</label>
                    <textarea name="address" id="address" class="form-control">{{ old('address', $patient->address) }}</textarea>
                    @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Status --}}
                <div class="col-md-4 mb-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" {{ old('status', $patient->status) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $patient->status) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Update Patient</button>
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>

        </form>
    </div>
</div>
@endsection