@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header"><h4>Discharge Patient</h4></div>

    <div class="card-body">
        <form method="POST" action="{{ route('ipd.discharge', $ipd->id) }}">
            @csrf

            <div class="mb-3">
                <label>Discharge Date</label>
                <input type="datetime-local" name="discharge_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Final Diagnosis</label>
                <textarea name="final_diagnosis" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label>Discharge Summary</label>
                <textarea name="discharge_summary" class="form-control" required></textarea>
            </div>

            <button class="btn btn-success">Discharge Patient</button>
        </form>
    </div>
</div>
@endsection
