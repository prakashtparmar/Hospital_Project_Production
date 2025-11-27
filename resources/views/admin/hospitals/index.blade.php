<!-- resources/views/admin/hospitals/index.blade.php -->

@extends('layouts.admin')

@section('content')
    <h1>Hospitals</h1>
    <a href="{{ route('admin.hospitals.create') }}" class="btn btn-primary">Create Hospital</a>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Subdomain</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hospitals as $hospital)
                <tr>
                    <td>{{ $hospital->data['name'] }}</td>
                    <td>{{ $hospital->data['contact'] }}</td>
                    <td>{{ $hospital->domains->first()->domain }}</td>
                    <td>
                        <a href="{{ route('admin.hospitals.edit', $hospital) }}">Edit</a>
                        <form action="{{ route('admin.hospitals.destroy', $hospital) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
