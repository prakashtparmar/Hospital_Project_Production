@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1><i class="fa fa-plus"></i> New Stock Adjustment</h1>
</div>

<div class="row">
    <div class="col-md-6">

        <form action="{{ route('stock-adjustments.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Medicine</label>
                <select name="medicine_id" class="form-control" required>
                    <option value="">-- Select Medicine --</option>
                    @foreach ($medicines as $m)
                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Adjustment Quantity</label>
                <input
                    type="number"
                    name="adjust_quantity"
                    class="form-control"
                    required
                    placeholder="Use + for increase, − for decrease (e.g. 10 or -5)">
            </div>

            <div class="form-group">
                <label>Reason</label>
                <textarea name="reason" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
            <a href="{{ route('stock-adjustments.index') }}" class="btn btn-default">Cancel</a>
        </form>

    </div>
</div>

@endsection
