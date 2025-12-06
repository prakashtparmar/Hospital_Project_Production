<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 13px;
            line-height: 1.6;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
        }
        .box {
            border: 1px solid #444;
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 4px;
        }
        .row {
            display: flex;
            justify-content: space-between;
        }
        .col {
            width: 48%;
        }
        .label {
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Discharge Summary</h2>

{{-- PATIENT DETAILS --}}
<div class="box">
    <div class="section-title">Patient Details</div>

    <div class="row">
        <div class="col">
            <span class="label">IPD No:</span> {{ $ipd->ipd_no }} <br>
            <span class="label">Patient Name:</span> {{ $ipd->patient->full_name }} <br>
        </div>
        <div class="col">
            <span class="label">Doctor:</span> {{ $ipd->doctor->name ?? '-' }} <br>
            <span class="label">Department:</span> {{ $ipd->department->name ?? '-' }} <br>
        </div>
    </div>
</div>

{{-- ADMISSION / DISCHARGE DETAILS --}}
<div class="box">
    <div class="section-title">Admission & Discharge</div>

    <div class="row">
        <div class="col">
            <span class="label">Admission Date:</span>
            {{ \Carbon\Carbon::parse($ipd->admission_date)->format('d M Y, h:i A') }} <br>
        </div>

        <div class="col">
            <span class="label">Discharge Date:</span>
            {{ \Carbon\Carbon::parse($ipd->discharge_date)->format('d M Y, h:i A') }} <br>
        </div>
    </div>
</div>

{{-- DIAGNOSIS --}}
<div class="box">
    <div class="section-title">Final Diagnosis</div>
    {!! nl2br(e($ipd->final_diagnosis)) !!}
</div>

{{-- DISCHARGE SUMMARY --}}
<div class="box">
    <div class="section-title">Discharge Summary</div>
    {!! nl2br(e($ipd->discharge_summary)) !!}
</div>

</body>
</html>
