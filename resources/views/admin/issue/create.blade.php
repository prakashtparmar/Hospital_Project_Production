@extends('layouts.auth')

@section('content')

<div class="card">
    <div class="card-header"><h4>Issue Medicines</h4></div>

    <div class="card-body">
        <form action="{{ route('issue-medicines.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Patient</label>
                <select name="patient_id" class="form-control">
                    @foreach($patients as $p)
                        <option value="{{ $p->id }}">{{ $p->full_name }}</option>
                    @endforeach
                </select>
            </div>

            <hr>

            <h5>Medicines</h5>
            <div id="medicineRepeater">

                <div class="row mb-2">
                    <div class="col-md-6">
                        <select name="medicine_id[]" class="form-control">
                            @foreach($medicines as $m)
                                <option value="{{ $m->id }}">{{ $m->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <input type="number" name="quantity[]" class="form-control" placeholder="Qty">
                    </div>

                    <div class="col-md-3">
                        <button type="button" class="btn btn-danger w-100" onclick="this.parentNode.parentNode.remove()">Remove</button>
                    </div>
                </div>

            </div>

            <button type="button" class="btn btn-secondary mb-3" onclick="addRow()">+ Add Medicine</button>

            <button class="btn btn-success">Issue</button>

        </form>
    </div>
</div>

<script>
function addRow() {
    const html = `
        <div class="row mb-2">
            <div class="col-md-6">
                <select name="medicine_id[]" class="form-control">
                    @foreach($medicines as $m)
                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <input type="number" name="quantity[]" class="form-control" placeholder="Qty">
            </div>

            <div class="col-md-3">
                <button type="button" class="btn btn-danger w-100" onclick="this.parentNode.parentNode.remove()">Remove</button>
            </div>
        </div>
    `;
    document.getElementById('medicineRepeater').insertAdjacentHTML('beforeend', html);
}
</script>

@endsection
