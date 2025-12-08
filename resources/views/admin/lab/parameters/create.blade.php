@extends('layouts.app')

@section('content')
<h4>Add Parameters for {{ $lab_test->name }}</h4>

<form method="POST" action="{{ route('lab.parameters.store',$lab_test->id) }}">
@csrf

<table class="table">
<tr>
    <th>Name</th>
    <th>Unit</th>
    <th>Reference Range</th>
</tr>

@for($i=0;$i<5;$i++)
<tr>
    <td><input type="text" name="name[]" class="form-control"></td>
    <td><input type="text" name="unit[]" class="form-control"></td>
    <td><input type="text" name="ref[]" class="form-control"></td>
</tr>
@endfor
</table>

<button class="btn btn-success">Save</button>
<a href="{{ route('lab-tests.index') }}" class="btn btn-secondary">Back</a>

</form>
@endsection
