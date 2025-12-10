<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Employee Health Record</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h1 {
            text-align: center;
            margin-bottom: 0;
            font-weight: bold;
            font-size: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        h3 {
            text-align: center;
            margin-top: 5px;
            margin-bottom: 15px;
            font-weight: normal;
            font-size: 15px;
        }

        th {
            text-align: left;
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        thead th {
            background: #e0e0e0;
            font-weight: bold;
            font-size: 13px;
            text-align: left;
        }

        /* PRINT SETTINGS */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                font-size: 10px;
                /* reduce to fit one page */
            }

            table {
                page-break-inside: avoid;
            }

            tr,
            td,
            th {
                page-break-inside: avoid !important;
                page-break-after: auto;
            }

            h1,
            h2,
            h3 {
                page-break-after: avoid;
                page-break-inside: avoid;
            }

            @page {
                size: A4;
                margin: 8mm;
            }
        }

        /* REAL FOOTER ON EVERY PRINTED PAGE */
        .print-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            font-style: italic;
        }

        /* Page number style */
        .page-number::after {
            content: "Page " counter(page);
        }
    </style>
</head>

<body>

    <!-- ACTUAL FOOTER (PRINTS ON EVERY PAGE) -->
    <div class="print-footer">
        Note: Age & Date Of Joining is as declared by the person, it cannot be produced as proof of age or date of
        joining.
        <br>
        — <span class="page-number"></span>
    </div>


    <h1>Divit Hospital</h1>
    <h3>Medical Check-up Report</h3>

    {{-- SECTION 1 --}}
    <table>
        <thead>
            <tr>
                <th colspan="4">Employee Information</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td>Employee No:</td>
                <td>{{ $product->EmployeeNo }}</td>
                <td>Date of Examination:</td>
                <td>{{ \Carbon\Carbon::parse($product->DateOfExamination)->format('d-m-Y') }}</td>

            </tr>

            <tr>
                <td>Employee Name:</td>
                <td>{{ $product->EmployeeName }}</td>
                <td>Father's Name:</td>
                <td>{{ $product->FathersName }}</td>
            </tr>

            <tr>
                <td>Date Of Birth / Age:</td>
                <td>
                    {{ \Carbon\Carbon::parse($product->DateOfBirth)->format('d-m-Y') }}
                    / {{ \Carbon\Carbon::parse($product->DateOfBirth)->age }}
                </td>
                <td>Department:</td>
                <td>{{ $product->Department }}</td>
            </tr>

            <tr>
                <td>Sex:</td>
                <td>{{ ucfirst($product->Sex) }}</td>
                <td>Joining Date:</td>
                <td>{{ \Carbon\Carbon::parse($product->JoiningDate)->format('d-m-Y') }}</td>

            </tr>

            <tr>
                <td>Identification Mark:</td>
                <td>{{ $product->IdentificationMark }}</td>
                <td>H/O Habit:</td>
                <td>{{ $product->H_OHabit }}</td>
            </tr>

            <tr>
                <td>Marital Status:</td>
                <td>{{ $product->MaritalStatus }}</td>
                <td>Designation:</td>
                <td>{{ $product->Designation }}</td>
            </tr>

            <tr>
                <td>Husband's Name:</td>
                <td>{{ $product->HusbandsName }}</td>
                <td>Company:</td>
                <td>{{ $product->Company }}</td>
            </tr>

            <tr>
                <td>Dependents:</td>
                <td>{{ $product->Dependent }}</td>
                <td>Prev. Occ. History:</td>
                <td>{{ $product->Prev_Occ_History }}</td>
            </tr>

            <tr>
                <td>Mobile Number:</td>
                <td>{{ $product->Mobile }}</td>
                <td>Address:</td>
                <td>{{ $product->Address }}</td>
            </tr>

        </tbody>
    </table>


    {{-- SECTION 3 --}}
    <table>
        <thead>
            <tr>
                <th colspan="4">Physical Examination</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Temperature</td>
                <td>{{ $product->Temperature }}</td>
                <td>Pulse</td>
                <td>{{ $product->Pulse }}</td>

            </tr>
            <tr>
                <td>Chest Before Breathing</td>
                <td>{{ $product->ChestBeforeBreathing }}</td>
                <td>Chest After Breathing</td>
                <td>{{ $product->ChestAfterBreathing }}</td>


            </tr>
            <tr>
                <td>Weight</td>
                <td>{{ $product->Weight }}</td>
                <td>Height</td>
                <td>{{ $product->Height }}</td>


            </tr>
            <tr>
                <td>BP</td>
                <td>{{ $product->BP }}</td>
                <td>BMI</td>
                <td>{{ $product->BMI }}</td>
            </tr>
            <tr>
                <td>SpO2</td>
                <td>{{ $product->SpO2 }}</td>
                <td>Respiration Rate</td>
                <td>{{ $product->RespirationRate }}</td>
            </tr>
        </tbody>
    </table>

    {{-- SECTION 4 --}}
    <style>
        table.vision-table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        table.vision-table th,
        table.vision-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        table.vision-table th.section-title {
            background: #e0e0e0;
            text-align: left;
            font-weight: bold;
        }
    </style>

    <table class="vision-table">
        <thead>
            <tr>
                <th class="section-title" colspan="3">Vision</th>
            </tr>
            <tr>
                <th></th>
                <th>Right Eye</th>
                <th>Left Eye</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Specs :</td>
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
        </tbody>
    </table>

    <!-- SECTION 5: Local Examination -->
    <table>
        <thead>
            <tr>
                <th colspan="3">Local Examination</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Eye : {{ $product->Eye }}</td>
                <td>Nose : {{ $product->Nose }}</td>
                <td>Conjunctiva : {{ $product->Conjunctiva }}</td>
            </tr>

            <tr>
                <td>Ear : {{ $product->Ear }}</td>
                <td>Tongue : {{ $product->Tongue }}</td>
                <td>Nails : {{ $product->Nails }}</td>
            </tr>

            <tr>
                <td>Throat : {{ $product->Throat }}</td>
                <td>Skin : {{ $product->Skin }}</td>
                <td>Teeth : {{ $product->Teeth }}</td>
            </tr>

            <tr>
                <td>PEFR : {{ $product->PEFR }}</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Eczema : {{ $product->Eczema }}</td>
                <td>Cyanosis : {{ $product->Cyanosis }}</td>
                <td>Jaundice : {{ $product->Jaundice }}</td>
            </tr>

            <tr>
                <td>Anaemia : {{ $product->Anaemia }}</td>
                <td>Oedema : {{ $product->Oedema }}</td>
                <td>Clubbing : {{ $product->Clubbing }}</td>
            </tr>

            <tr>
                <td>Allergy : {{ $product->Allergy }}</td>
                <td>Lymphnode : {{ $product->Lymphnode }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- SECTION 6: Medical History Examination -->
    <table>
        <thead>
            <tr>
                <th colspan="3">Medical History Examination</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Known Hypertension : {{ $product->KnownHypertension }}</td>
                <td>Diabetes : {{ $product->Diabetes }}</td>
                <td>Dyslipidemia : {{ $product->Dyslipidemia }}</td>
            </tr>

            <tr>
                <td>Radiation Effect : {{ $product->RadiationEffect }}</td>
                <td>Vertigo : {{ $product->Vertigo }}</td>
                <td>Tuberculosis : {{ $product->Tuberculosis }}</td>
            </tr>

            <tr>
                <td>Thyroid Disorder : {{ $product->ThyroidDisorder }}</td>
                <td>Epilepsy : {{ $product->Epilepsy }}</td>
                <td>Br. Asthma : {{ $product->Br_Asthma }}</td>
            </tr>

            <tr>
                <td>Heart Disease : {{ $product->HeartDisease }}</td>
                <td>Present Complain : {{ $product->PresentComplain }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- SECTION 7: Systemic Examination -->
    <table>
        <thead>
            <tr>
                <th colspan="3">Systemic Examination</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Respiration System : {{ $product->RespirationSystem }}</td>
                <td>Genito-Urinary : {{ $product->GenitoUrinary }}</td>
                <td>CVS : {{ $product->CVS }}</td>
            </tr>

            <tr>
                <td>CNS : {{ $product->CNS }}</td>
                <td>Per Abdomen : {{ $product->PerAbdomen }}</td>
                <td>ENT : {{ $product->ENT }}</td>
            </tr>
        </tbody>
    </table>




    <!-- SECTION 6 – FAMILY HISTORY -->
    <table>
        <thead>
            <tr>
                <th colspan="3">Family History</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Father : {{ $product->Father }}</td>
                <td>Mother : {{ $product->Mother }}</td>
                <td>Brother : {{ $product->Brother }}</td>
            </tr>
            <tr>
                <td>Sister : {{ $product->Sister }}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>


    <!-- SECTION 7 – LAB INVESTIGATIONS -->
    <table>
        <thead>
            <tr>
                <th colspan="3">Lab Investigations</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>HB : {{ $product->HB }}</td>
                <td>WBC : {{ $product->WBC }}</td>
                <td>Paasite : {{ $product->Paasite }}</td>
            </tr>

            <tr>
                <td>RBC : {{ $product->RBC }}</td>
                <td>Platelet : {{ $product->Platelet }}</td>
                <td>ESR : {{ $product->ESR }}</td>
            </tr>

            <tr>
                <td>FBS : {{ $product->FBS }}</td>
                <td>PP2BS : {{ $product->PP2BS }}</td>
                <td>SGPT : {{ $product->SGPT }}</td>
            </tr>

            <tr>
                <td>SCreatintine : {{ $product->SCreatintine }}</td>
                <td>RBS : {{ $product->RBS }}</td>
                <td>SChol : {{ $product->SChol }}</td>
            </tr>

            <tr>
                <td>STRG : {{ $product->STRG }}</td>
                <td>SHDL : {{ $product->SHDL }}</td>
                <td>SLDL : {{ $product->SLDL }}</td>
            </tr>

            <tr>
                <td>CHRatio : {{ $product->CHRatio }}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>


    <!-- SECTION 8 – URINE ANALYSIS -->
    <table>
        <thead>
            <tr>
                <th colspan="3">Urine Analysis</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Urine Colour : {{ $product->UrineColour }}</td>
                <td>Urine Reaction : {{ $product->UrineReaction }}</td>
                <td>Urine Albumin : {{ $product->UrineAlbumin }}</td>
            </tr>

            <tr>
                <td>Urine Sugar : {{ $product->UrineSugar }}</td>
                <td>Urine Pus Cell : {{ $product->UrinePusCell }}</td>
                <td>Urine RBC : {{ $product->UrineRBC }}</td>
            </tr>

            <tr>
                <td>Urine Epi Cell : {{ $product->UrineEpiCell }}</td>
                <td>Urine Crystal : {{ $product->UrineCrystal }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>


    <table style="border-collapse: collapse; width:100%;">
        <thead>
            <tr>
                <th colspan="2">Doctor & Remarks</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding:8px 0;">Health Status : {{ $product->HealthStatus }}</td>
                <td style="padding:8px 0;"></td>
            </tr>

            <tr>
                <td style="padding:8px 0;">Doctor Name : {{ $product->NameOfDoctor }}</td>
                <td style="padding:8px 0;"></td>
            </tr>

            <tr>
                <td style="padding:8px 0;">Doctor Signature : {{ $product->DoctorSignature }}</td>
                <td style="padding:8px 0;">Seal of Doctor :</td>
            </tr>

            <tr>
                <td style="padding:8px 0;">Job Restriction (if any) : {{ $product->JobRestriction }}</td>
                <td style="padding:8px 0;"></td>
            </tr>

            <tr>
                <td style="padding:8px 0;">Doctor Remarks : {{ $product->DoctorsRemarks }}</td>
                <td style="padding:8px 0;"></td>
            </tr>

            <tr>
                <td style="padding:8px 0;">Reviewed By : {{ $product->ReviewedBy }}</td>
                <td style="padding:8px 0;"></td>
            </tr>
        </tbody>
    </table>

</html>