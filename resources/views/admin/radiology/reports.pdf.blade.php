<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        h2 { text-align:center; }
    </style>
</head>
<body>

<h2>Radiology Report</h2>

<p><strong>Patient:</strong> {{ $radiology_request->patient->full_name }}</p>

<h4>Report</h4>
<p>{!! nl2br($radiology_request->report->report ?? '') !!}</p>

<h4>Impression</h4>
<p>{!! nl2br($radiology_request->report->impression ?? '') !!}</p>

</body>
</html>
