@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('lab-requests.index') }}">Lab Requests</a>
        </li>
        <li class="active">
            {{ $lab_request->status === 'Completed' ? 'View Results' : 'Enter Results' }}
        </li>
    </ul>
</div>
@endsection

@section('content')

{{-- HEADER --}}
<div class="page-header d-flex justify-content-between align-items-center">
    <h4 class="page-title">
        {{ $lab_request->status === 'Completed' ? 'Lab Results' : 'Enter Lab Results' }}
    </h4>

    <a href="{{ route('lab-requests.index') }}" class="btn btn-default btn-sm">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>

{{-- PATIENT INFO --}}
<div class="alert alert-info">
    <strong>Patient:</strong>
    {{ $lab_request->patient->first_name ?? '' }}
    {{ $lab_request->patient->last_name ?? '' }}
    <br>

    <strong>Patient ID:</strong>
    {{ $lab_request->patient->patient_id ?? '—' }}
    <br>

    <strong>Request ID:</strong>
    {{ $lab_request->id }}
    <br>

    <strong>Status:</strong>
    <span class="label label-success">
        {{ $lab_request->status }}
    </span>
</div>

{{-- FORM --}}
<form method="POST" action="{{ route('lab-results.update', $lab_request->id) }}">
    @csrf

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="25%">Test</th>
                    <th width="35%">Parameter</th>
                    <th width="20%">Result</th>
                    <th width="20%">Reference Range</th>
                </tr>
            </thead>

            <tbody>
            @forelse($lab_request->items as $item)
                @foreach($item->test->parameters as $p)

                    @php
                        $existing = $lab_request->results
                            ? $lab_request->results->firstWhere('parameter_id', $p->id)
                            : null;
                    @endphp

                    <tr>
                        {{-- TEST --}}
                        <td>
                            <strong>{{ $item->test->name }}</strong>
                        </td>

                        {{-- PARAMETER --}}
                        <td>
                            {{ $p->name }}
                            @if($p->unit)
                                ({{ $p->unit }})
                            @endif
                        </td>

                        {{-- VALUE --}}
                        <td>
                            <input type="hidden" name="parameter_id[]" value="{{ $p->id }}">

                            <input type="text"
                                   name="value[]"
                                   class="form-control"
                                   value="{{ $existing->value ?? '' }}"
                                   {{ $lab_request->status === 'Completed' ? 'readonly' : '' }}>
                        </td>

                        {{-- REFERENCE --}}
                        <td>
                            <span class="text-muted">
                                {{ $p->reference_range ?? '—' }}
                            </span>
                        </td>
                    </tr>

                @endforeach
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        No test parameters found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- SAVE BUTTON --}}
    @if($lab_request->status !== 'Completed')
        <div class="text-center mt-3">
            <button class="btn btn-success btn-lg">
                <i class="fa fa-save"></i> Save Results
            </button>
        </div>
    @endif

</form>

@endsection
