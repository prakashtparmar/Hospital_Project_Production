@extends('layouts.auth')

@section('content')
<div class="card shadow">
    <div class="card-header text-center"><strong>Register</strong></div>
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input name="email" type="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input name="password" type="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input name="password_confirmation" type="password" class="form-control" required>
            </div>

            <button class="btn btn-success w-100">Create Account</button>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}">Already have an account?</a>
            </div>
        </form>
    </div>
</div>
@endsection
