@extends('layouts.auth')

@section('content')

<div class="card">
    <div class="card-header"><h4>Adjust Stock</h4></div>

    <div class="card-body">

        <form action="{{ route('stock-adjustments.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Medicine</label>
                <select name="medicine_id" class="form-control">
                    @foreach($medicines as $m)
                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Adjust Quantity (+ or -)</label>
                <input type="number" name="adjust_quantity" class="form-control">
            </div>

            <div class="mb-3">
                <label>Reason</label>
                <textarea name="reason" class="form-control"></textarea>
            </div>

            <button class="btn btn-success">Save</button>

        </form>

    </div>
</div>

@endsection
