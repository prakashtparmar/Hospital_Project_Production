@extends('layouts.admin')
@section('content')
<h3>Edit Category</h3>

<form method="POST" action="{{ route('radiology-categories.update',$radiology_category) }}">
@csrf @method('PUT')
<input type="text" name="name" value="{{ $radiology_category->name }}" class="form-control mb-2">
<button class="btn btn-success">Update</button>
</form>
@endsection
