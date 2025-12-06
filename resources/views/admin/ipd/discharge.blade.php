@extends('layouts.app')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('ipd.index') }}">IPD Admissions</a>
        </li>
        <li class="active">Discharge Patient</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h1>
        Discharge Patient
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Final Discharge Details
        </small>
    </h1>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Discharge Information</h4>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <form method="POST" action="{{ route('ipd.discharge', $ipd->id) }}">
                        @csrf

                        {{-- Discharge Date --}}
                        <div class="form-group">
                            <label><strong>Discharge Date & Time</strong></label>
                            <input type="datetime-local" name="discharge_date" id="dischargeDateTime"
                                   class="form-control" required>
                        </div>

                        {{-- Final Diagnosis --}}
                        <div class="form-group mt-2">
                            <label><strong>Final Diagnosis</strong></label>
                            <textarea name="final_diagnosis" class="form-control" rows="3" required></textarea>
                        </div>

                        {{-- Discharge Summary --}}
                        <div class="form-group mt-2">
                            <label><strong>Discharge Summary</strong></label>
                            <textarea name="discharge_summary" class="form-control" rows="4" required></textarea>
                        </div>

                        <div class="text-right mt-3">
                            <button class="btn btn-success btn-sm">
                                <i class="fa fa-check"></i> Confirm Discharge
                            </button>
                            <a href="{{ route('ipd.show', $ipd->id) }}" class="btn btn-default btn-sm">
                                <i class="fa fa-arrow-left"></i> Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
// Auto-set current date & time in IST
document.addEventListener("DOMContentLoaded", function() {
    let now = new Date();

    now.setMinutes(now.getMinutes() - now.getTimezoneOffset()); // Fix timezone offset

    document.getElementById("dischargeDateTime").value =
        now.toISOString().slice(0, 16); // YYYY-MM-DDTHH:MM
});
</script>
@endpush
