<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Health Register Form No. 32</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        @font-face {
            font-family: 'DejaVuSans';
            src: local('DejaVu Sans'), local('DejaVuSans');
        }

        body {
            font-family: DejaVuSans, Arial, sans-serif;
            font-size: 10px; /* Slightly larger font */
            margin: 0;
            padding: 4mm; /* Slightly increased padding */
            color: #000;
        }

        h1,
        h2 {
            margin: 0;
            text-align: center;
            font-weight: bold;
        }

        h1 {
            font-size: 15px; /* Larger */
            margin-bottom: 2mm;
        }

        h2 {
            font-size: 14px; /* Larger */
            margin-bottom: 2mm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid;
            font-size: 9px; /* Slightly larger table font */
        }

        table.form32-table th,
        table.form32-table td,
        .vision-table th,
        .vision-table td {
            border: 1px solid #000;
            padding: 2px; /* Slightly more padding */
            text-align: center;
            vertical-align: top;
            page-break-inside: avoid;
        }

        .vision-table td,
        .vision-table th {
            padding: 2px;
        }

        @page {
            size: A4 landscape;
            margin: 5mm;
        }

        body,
        html {
            height: 100%;
            overflow: visible;
        }

        tr,
        td,
        th {
            page-break-inside: avoid;
        }

        td {
            text-align: left;
        }

        @media print {
            body {
                font-size: 9px; /* Slightly larger font for print */
                padding: 3mm;
                transform: scale(0.95);
                transform-origin: top left;
            }

            h1 {
                font-size: 16px;
            }

            h2 {
                font-size: 12px;
            }

            table,
            th,
            td {
                font-size: 8.5px;
                padding: 2px;
            }
        }
    </style>

</head>

<body>

    <h1>FORM NO. 32</h1>
    <h2>(Prescribed under Rule 68-T and 102)</h2>
    <h1>HEALTH REGISTER</h1>

    <table>
        <tr>
            <td><strong>1. Serial number in the register :</strong></td>
            <td>{{ $product->EmployeeNo }}</td>
            <td><strong>2. Name of Worker:</strong></td>
            <td>{{ $product->EmployeeName }}</td>
        </tr>

        <tr>
            <td><strong>3. Sex:</strong></td>
            <td>{{ ucfirst($product->Sex) }}</td>
            <td><strong>4. Date of Birth / Age:</strong></td>
            <td>
                {{ \Carbon\Carbon::parse($product->DateOfBirth)->format('d-m-Y') }}
                ({{ \Carbon\Carbon::parse($product->DateOfBirth)->age }} Years)
            </td>
        </tr>

        <tr>
            <td><strong>5. Company :</strong></td>
            <td>{{ $product->Company }}</td>
            <td><strong>6. Address :</strong></td>
            <td>{{ $product->Address }}</td>
        </tr>
    </table>

    <br>

    <table class="form32-table">
        <thead>
            <tr>
                <th rowspan="2">Department / Works</th>
                <th rowspan="2">Hazardous Process</th>
                <th rowspan="2">Dangerous Operation</th>
                <th rowspan="2">Nature of Job</th>
                <th rowspan="2">Exposure Materials</th>
                <th rowspan="2">Date of Posting</th>
                <th rowspan="2">Date of Leaving</th>
                <th rowspan="2">Reason for Transfer</th>
                <th colspan="4">Medical Examination</th>
                <th colspan="4">If Declared Unfit</th>
                <th rowspan="2">Doctor Signature</th>
            </tr>
            <tr>
                <th>Date</th>
                <th>Signs and symptoms Observed during examination</th>
                <th>Nature of tests + result thereof</th>
                <th>Result Fit/Unfit</th>
                <th>Period of temporary Withdrawal from that work</th>
                <th>Reasons for such withdrawal</th>
                <th>Date of declaring him Unfit for that work</th>
                <th>Date of issuing Fitness Certificate</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>{{ $product->Designation }}</td>
                <td>{{ $product->HazardousProcess }}</td>
                <td>{{ $product->DangerousOperation }}</td>
                <td></td>
                <td>{{ $product->JoiningDate }}</td>
                <td></td>
                <td></td>
                <td>{{ $product->JoiningDate }}</td>
                <td>{{ $product->MedExamDate }}</td>
                <td style="text-align:left; white-space:pre-line;">
                    • Temperature: {{ $product->Temperature }}
                    • Pulse: {{ $product->Pulse }}
                    • Chest Before Breathing: {{ $product->ChestBeforeBreathing }}
                    • Chest After Breathing: {{ $product->ChestAfterBreathing }}
                    • Weight: {{ $product->Weight }}
                    • Height: {{ $product->Height }}
                    • BP: {{ $product->BP }}
                    • BMI: {{ $product->BMI }}
                    • SpO₂: {{ $product->SpO2 }}
                    • Respiration Rate: {{ $product->RespirationRate }}

                    <table class="vision-table">
                        <tr>
                            <th>Vision</th>
                            <th>Right Eye</th>
                            <th>Left Eye</th>
                        </tr>
                        <tr>
                            <td>Specs</td>
                            <td>{{ $product->RightEyeSpecs }}</td>
                            <td>{{ $product->LeftEyeSpecs }}</td>
                        </tr>
                        <tr>
                            <td>Near Vision</td>
                            <td>{{ $product->NearVisionRight }}</td>
                            <td>{{ $product->NearVisionLeft }}</td>
                        </tr>
                        <tr>
                            <td>Distant Vision</td>
                            <td>{{ $product->DistantVisionRight }}</td>
                            <td>{{ $product->DistantVisionLeft }}</td>
                        </tr>
                        <tr>
                            <td>Colour Vision</td>
                            <td colspan="2">{{ $product->ColourVision }}</td>
                        </tr>
                    </table>
                    • Eye: {{ $product->Eye }}
                    • Nose: {{ $product->Nose }}
                    • Conjunctiva: {{ $product->Conjunctiva }}
                    • Ear: {{ $product->Ear }}
                    • Tongue: {{ $product->Tongue }}
                    • Nails: {{ $product->Nails }}
                    • Throat: {{ $product->Throat }}
                    • Skin: {{ $product->Skin }}
                    • Teeth: {{ $product->Teeth }}
                    • PEFR: {{ $product->PEFR }}
                    • Eczema: {{ $product->Eczema }}
                    • Cyanosis: {{ $product->Cyanosis }}
                    • Jaundice: {{ $product->Jaundice }}
                    • Anaemia: {{ $product->Anaemia }}
                    • Oedema: {{ $product->Oedema }}
                    • Clubbing: {{ $product->Clubbing }}
                    • Allergy: {{ $product->Allergy }}
                    • Lymphnode: {{ $product->Lymphnode }}
                </td>
                <td>{{ $product->MedicalTestResult }}</td>
                <td>{{ $product->ResultFitUnfit }}</td>
                <td>{{ $product->WithdrawalPeriod }}</td>
                <td>{{ $product->ReasonWithdrawal }}</td>
                <td>{{ $product->FitnessCertificateDate }}</td>
                <td></td>
                <td>{{ $product->DoctorSignature }}</td>
            </tr>
        </tbody>
    </table>

    <p>
    Note:
    1. A separate page must be maintained for each worker.   
    2. A fresh entry must be made for each examination.
    </p>


</body>

</html>
