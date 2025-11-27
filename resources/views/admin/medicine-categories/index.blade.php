@extends('layouts.auth')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Medicine Categories</h4>
            <a href="{{ route('medicine-categories.create') }}" class="btn btn-primary btn-sm">Add Category</a>
        </div>

        <!-- On the medicines index page, simply add: Low Stock Alerts -->
         <!-- START -->
        @if($m->current_stock <= $m->reorder_level)
            <span class="badge bg-danger">Low Stock</span>
        @endif
        <!-- END -->


        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th width="150">Actions</th>
                </tr>

                @foreach($categories as $c)
                    <tr>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->status ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('medicine-categories.edit', $c->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('medicine-categories.destroy', $c->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete?')" class="btn btn-danger btn-sm">Del</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </table>

            {{ $categories->links() }}

        </div>
    </div>
@endsection