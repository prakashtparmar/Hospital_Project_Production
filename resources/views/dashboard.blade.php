@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-body text-center">
        <h3>Welcome to Hospital Management System</h3>
        <p>You are logged in!</p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger mt-3">Logout</button>
        </form>
    </div>
</div>
@endsection
