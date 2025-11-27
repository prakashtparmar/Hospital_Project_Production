<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        h2 { text-align: center; margin-bottom: 20px; }
        .box { border: 1px solid #000; padding: 10px; margin-bottom: 15px; }
    </style>
</head>
<body>

<h2>Discharge Summary</h2>

<div class="box">
    <strong>IPD No:</strong> {{ $ipd->ipd_no }} <br>
    <strong>Patient:</strong> {{ $ipd->patient->full_name }} <br>
    <strong>Doctor:</strong> {{ $ipd->doctor->name ?? '-' }} <br>
    <strong>Department:</strong> {{ $ipd->department->name ?? '-' }} <br>
</div>

<div class="box">
    <strong>Admission Date:</strong> {{ $ipd->admission_date }} <br>
    <strong>Discharge Date:</strong> {{ $ipd->discharge_date }} <br>
</div>

<div class="box">
    <strong>Final Diagnosis:</strong><br>
    {!! nl2br($ipd->final_diagnosis) !!}
</div>

<div class="box">
    <strong>Discharge Summary:</strong><br>
    {!! nl2br($ipd->discharge_summary) !!}
</div>

</body>
</html>
