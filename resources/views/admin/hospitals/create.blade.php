<!-- resources/views/admin/hospitals/create.blade.php -->

@extends('layouts.admin')

@section('content')
    <h1>Create Hospital</h1>

    <form action="{{ route('admin.hospitals.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Hospital Name</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label for="contact">Contact</label>
            <input type="text" name="contact" required>
        </div>
        <div>
            <label for="subdomain">Subdomain</label>
            <input type="text" name="subdomain" required>
        </div>
        <button type="submit">Create</button>
    </form>
@endsection
