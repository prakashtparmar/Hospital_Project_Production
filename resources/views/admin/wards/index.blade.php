@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Wards</h4>
        <a href="{{ route('wards.create') }}" class="btn btn-primary btn-sm">Add Ward</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Status</th>
                <th width="150">Actions</th>
            </tr>

            @foreach($wards as $w)
            <tr>
                <td>{{ $w->name }}</td>
                <td>{{ $w->type }}</td>
                <td>{{ $w->status ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('wards.edit',$w->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form method="POST" action="{{ route('wards.destroy',$w->id) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>

        {{ $wards->links() }}
    </div>
</div>
@endsection
