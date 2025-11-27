@extends('layouts.auth')

@section('content')
<div class="card shadow">
    <div class="card-header text-center"><strong>Login</strong></div>
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Login</button>

            <div class="text-center mt-3">
                <a href="{{ route('register') }}">Create an account</a>
            </div>
        </form>
    </div>
</div>
@endsection
