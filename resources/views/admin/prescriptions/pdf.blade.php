<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Prescription #{{ $prescription->id }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .header {
            padding: 18px 25px;
            border-bottom: 3px solid #1e88e5;
            background: #f7faff;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #1e88e5;
        }

        .sub-header {
            padding: 10px 25px 15px;
            font-size: 14px;
            border-bottom: 1px solid #bbb;
            background: #fafafa;
        }

        .section-title {
            font-size: 16px;
            margin-top: 20px;
            margin-bottom: 8px;
            font-weight: bold;
            color: #1e88e5;
            border-left: 4px solid #1e88e5;
            padding-left: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 15px;
        }

        table th {
            background: #1e88e5;
            color: white;
            padding: 8px;
            font-size: 13px;
        }

        table td {
            border: 1px solid #bbb;
            padding: 8px;
            font-size: 12px;
        }

        .notes-box {
            border: 1px solid #bbb;
            padding: 10px;
            margin-top: 10px;
            background: #fefefe;
            min-height: 50px;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 40px;
            padding: 10px;
            color: #777;
            border-top: 1px solid #ddd;
        }

    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">
        <h1>Prescription</h1>
    </div>

    {{-- SUB HEADER --}}
    <div class="sub-header">
        <strong>Date:</strong> {{ $prescription->prescribed_on }} <br>
        <strong>Prescription ID:</strong> {{ $prescription->id }}
    </div>

    {{-- PATIENT DETAILS --}}
    <div class="section-title">Patient Details</div>
    <table>
        <tr>
            <th width="25%">Patient ID</th>
            <td>{{ $prescription->patient->patient_id }}</td>
        </tr>

        <tr>
            <th>Name</th>
            <td>{{ $prescription->patient->first_name }} {{ $prescription->patient->last_name }}</td>
        </tr>

        <tr>
            <th>Gender</th>
            <td>{{ $prescription->patient->gender }}</td>
        </tr>

        <tr>
            <th>Date of Birth</th>
            <td>{{ $prescription->patient->date_of_birth }}</td>
        </tr>
    </table>

    {{-- DOCTOR DETAILS --}}
    <div class="section-title">Doctor Details</div>
    <table>
        <tr>
            <th width="25%">Doctor</th>
            <td>{{ $prescription->doctor->name }}</td>
        </tr>
    </table>

    {{-- NOTES --}}
    @if(!empty($prescription->notes))
        <div class="section-title">General Notes</div>
        <div class="notes-box">
            {{ $prescription->notes }}
        </div>
    @endif

    {{-- MEDICINES --}}
    <div class="section-title">Medicines</div>

    <table>
        <thead>
            <tr>
                <th>Drug</th>
                <th>Strength</th>
                <th>Dose</th>
                <th>Route</th>
                <th>Frequency</th>
                <th>Duration</th>
                <th>Instructions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($prescription->items as $item)
            <tr>
                <td>{{ $item->drug_name }}</td>
                <td>{{ $item->strength }}</td>
                <td>{{ $item->dose }}</td>
                <td>{{ $item->route }}</td>
                <td>{{ $item->frequency }}</td>
                <td>{{ $item->duration }}</td>
                <td>{{ $item->instructions }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        This is a computer-generated prescription. No signature required.
    </div>

</body>
</html>
