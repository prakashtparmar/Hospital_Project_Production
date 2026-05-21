@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('radiology-requests.index') }}">Radiology Requests</a>
        </li>
        <li class="active">Radiology Report</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">Radiology Report</h4>
</div>

<div class="row">
    <div class="col-xs-12 col-md-10">

        <form method="POST"
              action="{{ route('radiology-reports.update', $radiology_request->id) }}"
              class="form-horizontal">
            @csrf
            @method('PUT') {{-- ✅ REQUIRED --}}

            {{-- Patient / Request Info --}}
            <div class="alert alert-info">
                <strong>Patient:</strong> {{ $radiology_request->patient?->full_name ?? 'N/A' }}
                &nbsp; | &nbsp;
                <strong>Status:</strong> {{ $radiology_request->status }}
            </div>

            {{-- Findings --}}
            <div class="form-group">
                <label class="control-label">Findings / Report</label>
                <textarea
                    name="report"
                    class="form-control"
                    rows="6"
                    placeholder="Enter radiology findings"
                    required>{{ old('report', $radiology_request->report?->report) }}</textarea>
            </div>

            {{-- Impression --}}
            <div class="form-group">
                <label class="control-label">Impression</label>
                <textarea
                    name="impression"
                    class="form-control"
                    rows="4"
                    placeholder="Enter impression">{{ old('impression', $radiology_request->report?->impression) }}</textarea>
            </div>

            {{-- Actions --}}
            <div class="form-group">

                {{-- ✅ CORRECT PERMISSIONS --}}
                @canany(['radiology-results.create','radiology-results.edit'])
                <button type="submit" class="btn btn-success">
                    <i class="ace-icon fa fa-save"></i> Save Report
                </button>
                @endcanany

                <a href="{{ route('radiology-requests.index') }}" class="btn btn-default">
                    <i class="ace-icon fa fa-arrow-left"></i> Back
                </a>

                @can('radiology-reports.download')
                    @if($radiology_request->status === 'Completed')
                    <a href="{{ route('radiology-reports.pdf',$radiology_request->id) }}"
                       class="btn btn-purple">
                        <i class="ace-icon fa fa-file-pdf-o"></i> Download PDF
                    </a>
                    @endif
                @endcan

            </div>

        </form>

    </div>
</div>

@endsection
