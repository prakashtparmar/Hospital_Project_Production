@extends('layouts.auth')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Add OPD Visit</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('opd.store') }}">
                @csrf

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Patient</label>
                        <select name="patient_id" class="form-control" required>
                            @foreach ($patients as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->patient_id }} - {{ $p->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Department</label>
                        <select name="department_id" class="form-control">
                            <option value="">-- select --</option>
                            @foreach ($departments as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- <div class="col-md-4 mb-3">
                        <label>Doctor</label>
                        <select name="doctor_id" class="form-control">
                            <option value="">-- select --</option>
                            @foreach ($doctors as $dr)
                                <option value="{{ $dr->id }}">{{ $dr->name }}</option>
                            @endforeach
                        </select>
                    </div> -->

                    @php
                        $today = \Carbon\Carbon::now()->format('l'); // e.g., Monday
                        $availableDoctors = \App\Models\DoctorSchedule::where('day', $today)
                            ->where('status', 1)
                            ->pluck('doctor_id');
                        $doctors = \App\Models\User::whereIn('id', $availableDoctors)->get();
                    @endphp

                    <select name="doctor_id" class="form-control">
                        <option value="">-- select --</option>
                        @foreach($doctors as $dr)
                            <option value="{{ $dr->id }}">{{ $dr->name }} (Available Today)</option>
                        @endforeach
                    </select>


                    <div class="col-md-4 mb-3">
                        <label>Visit Date</label>
                        <input type="date" name="visit_date" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>BP</label>
                        <input name="bp" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Temperature</label>
                        <input name="temperature" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Pulse</label>
                        <input name="pulse" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Weight</label>
                        <input name="weight" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Symptoms</label>
                        <textarea name="symptoms" class="form-control"></textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Diagnosis</label>
                        <textarea name="diagnosis" class="form-control"></textarea>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Closed</option>
                        </select>
                    </div>

                </div>

                <button class="btn btn-success">Save</button>

            </form>
        </div>
    </div>
@endsection