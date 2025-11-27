@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header"><h4>Admit Patient</h4></div>

    <div class="card-body">
        <form action="{{ route('ipd.store') }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label>Patient</label>
                    <select class="form-control" name="patient_id">
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->patient_id }} - {{ $p->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Doctor</label>
                    <select name="doctor_id" class="form-control">
                        @foreach($doctors as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Department</label>
                    <select name="department_id" class="form-control">
                        @foreach($departments as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                        @endforeach
                    </select>
                </div>

                <hr>

                <div class="col-md-4 mb-3">
                    <label>Ward</label>
                    <select name="ward_id" class="form-control">
                        @foreach($wards as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Room</label>
                    <select name="room_id" class="form-control">
                        @foreach($rooms as $r)
                            <option value="{{ $r->id }}">{{ $r->room_no }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Bed</label>
                    <select name="bed_id" class="form-control">
                        @foreach($beds as $b)
                            <option value="{{ $b->id }}">{{ $b->bed_no }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Admission Date</label>
                    <input type="datetime-local" name="admission_date" class="form-control">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Reason for Admission</label>
                    <textarea name="admission_reason" class="form-control"></textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Initial Diagnosis</label>
                    <textarea name="initial_diagnosis" class="form-control"></textarea>
                </div>

            </div>

            <button class="btn btn-success">Admit Patient</button>

        </form>
    </div>
</div>
@endsection
