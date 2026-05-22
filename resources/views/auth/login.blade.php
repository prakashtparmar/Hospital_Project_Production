@extends('layouts.auth')

@section('content')

<style>
    body.login-layout {
        background:
            linear-gradient(rgba(18, 39, 63, 0.62), rgba(18, 39, 63, 0.62)),
            url("{{ asset('ace/assets/images/gallery/image-1.jpg') }}") center/cover no-repeat fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .login-box {
        width: 420px !important;
        max-width: calc(100vw - 30px);
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(255, 255, 255, 0.7);
        border-radius: 8px;
        box-shadow: 0 18px 45px rgba(0, 0, 0, 0.28);
        padding: 34px 30px 30px;
        animation: fadeIn 0.45s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-control {
        height: 44px;
        border-radius: 6px !important;
        border: 1px solid #d5dbe4;
        padding-left: 42px;
        box-shadow: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: #2f7db6;
        box-shadow: 0 0 0 3px rgba(47, 125, 182, 0.15);
    }

    .input-icon-right i {
        top: 12px;
        font-size: 18px;
        color: #7d8998;
        opacity: 0.75;
        transition: color 0.2s ease, opacity 0.2s ease;
    }

    .form-control:focus + i {
        opacity: 1;
        color: #2f7db6;
    }

    .btn-login-animated {
        width: 100%;
        height: 44px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 700;
        background: #2f7db6;
        border: none;
        color: #fff;
        transition: background 0.2s ease, transform 0.2s ease;
    }

    .btn-login-animated:hover {
        background: #246b9e;
        transform: translateY(-1px);
    }

    .login-title {
        font-size: 27px;
        font-weight: 800;
        letter-spacing: 0;
        margin-bottom: 10px;
        color: #2f7db6;
    }

    .login-subtitle {
        font-size: 15px;
        font-weight: 500;
        color: #6f7a86;
    }

    .remember-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 24px;
    }

    .login-alert {
        border-radius: 6px;
        margin-bottom: 18px;
    }

    @media (max-width: 480px) {
        .login-box {
            padding: 28px 22px;
        }
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
        <div class="alert alert-danger text-center login-alert">
            {{ $errors->first() }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success text-center login-alert">
            {{ session('success') }}
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
                       value="{{ old('email', request()->cookie('remembered_login_email')) }}"
                       autocomplete="email"
                       autofocus
                       required />
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
                       autocomplete="current-password"
                       required />
                <i class="ace-icon fa fa-lock"></i>
            </span>
        </label>

        {{-- Remember Me --}}
        <div class="mb-3 remember-row">
            <label class="inline">
                <input type="checkbox"
                       name="remember"
                       value="1"
                       class="ace"
                       {{ old('remember', request()->cookie('remembered_login_email') ? '1' : null) ? 'checked' : '' }}>
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
