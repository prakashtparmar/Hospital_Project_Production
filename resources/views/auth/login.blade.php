@extends('layouts.auth')

@section('content')

<style>
    /* Modern gradient background */
    body.login-layout {
        background: linear-gradient(135deg, #4e73df, #1cc88a);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    /* Stylish login container */
    .login-box {
        width: 420px !important;
        background: #ffffffd9;
        border-radius: 12px;
        box-shadow: 0px 10px 28px rgba(0,0,0,0.25);
        padding: 35px 30px;
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Input field effects */
    .form-control {
        height: 45px;
        border-radius: 8px;
        border: 1px solid #ccc;
        padding-left: 40px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 8px rgba(78,115,223,0.4);
    }

    .input-icon-right i {
        top: 12px;
        font-size: 18px;
        opacity: 0.5;
        transition: 0.3s;
    }

    .form-control:focus + i {
        opacity: 1;
        color: #4e73df;
    }

    /* Button styling */
    .btn-login-animated {
        width: 100%;
        height: 45px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        background: linear-gradient(135deg, #1cc88a, #0da672);
        border: none;
        color: white;
        transition: 0.3s ease;
    }
    .btn-login-animated:hover {
        background: linear-gradient(135deg, #0da672, #0a8f61);
        transform: scale(1.03);
    }

    /* Title */
    .login-title {
        font-size: 28px;
        font-weight: 800;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .login-subtitle {
        font-size: 15px;
        font-weight: 500;
        opacity: 0.9;
    }
</style>

<div class="login-box">

    <div class="text-center mb-3">
        <h1 class="login-title text-primary">
            <i class="fa fa-hospital-o"></i> HMS Login
        </h1>
        <p class="login-subtitle">Hospital Management System</p>
    </div>

    {{-- Validation Error --}}
    @if ($errors->any())
        <div class="alert alert-danger text-center">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.store') }}" method="POST">
        @csrf

        {{-- Email --}}
<label class="block clearfix mb-3">
    <span class="block input-icon input-icon-right">
        <input type="email"
               name="email"
               class="form-control"
               placeholder="Email Address"
               value="admin@example.com"  required />
        <i class="ace-icon fa fa-envelope"></i>
    </span>
</label>

{{-- Password --}}
<label class="block clearfix mb-3">
    <span class="block input-icon input-icon-right">
        <input type="password"
               name="password"
               class="form-control"
               placeholder="Password"
               value="password"  required />
        <i class="ace-icon fa fa-lock"></i>
    </span>
</label>
        {{-- Remember Me --}}
        <div class="mb-3">
            <label class="inline">
                <input type="checkbox" name="remember" class="ace">
                <span class="lbl"> Remember Me</span>
            </label>
        </div>

        {{-- Login Button --}}
        <button type="submit" class="btn-login-animated">
            <i class="fa fa-sign-in"></i> Login
        </button>

    </form>

</div>

@endsection
