<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Radiology Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }
        h2, h4 {
            margin-bottom: 5px;
        }
        hr {
            margin: 10px 0;
        }
        .section {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2 align="center">Radiology Report</h2>
    <hr>

    {{-- Patient Info --}}
    <div class="section">
        <p><span class="label">Patient:</span>
            {{ $radiology_request->patient?->name ?? 'N/A' }}
        </p>

        <p><span class="label">Request ID:</span>
            {{ $radiology_request->id }}
        </p>

        <p><span class="label">Status:</span>
            {{ $radiology_request->status }}
        </p>

        <p><span class="label">Report Date:</span>
            {{ $radiology_request->updated_at?->format('d M, Y') }}
        </p>
    </div>

    <hr>

    {{-- Report --}}
    <div class="section">
        <h4>Findings</h4>
        <p>
            {!! nl2br(e($radiology_request->report?->report)) !!}
        </p>
    </div>

    {{-- Impression --}}
    <div class="section">
        <h4>Impression</h4>
        <p>
            {!! nl2br(e($radiology_request->report?->impression)) !!}
        </p>
    </div>

    <hr>

    {{-- Footer --}}
    <div class="section">
        <p><strong>Radiologist Signature:</strong> ________________________</p>
        <p><strong>Date:</strong> ________________________</p>
    </div>

</body>
</html>
