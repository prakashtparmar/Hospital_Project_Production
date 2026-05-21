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

        /* th,
        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        } */

        table {
            width: 100%;
            margin-bottom: 12px;

        }




        /* thead th {
            background: #e0e0e0;
            font-weight: bold;
            font-size: 13px;
            text-align: left;
        }  */

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                font-size: 10px;
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

        .print-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            font-style: italic;
        }

        .page-number::after {
            content: "Page " counter(page);
        }
    </style>
</head>

<body>
    <!-- Footer -->
    <div class="print-footer">
        Note: Age & Date Of Joining is as declared by the person, it cannot be produced as proof of age or date of
        joining.
        <br>
        <span class="page-number"></span>
    </div>

    <h1>FORM NO. 33</h1>
    <h3>( Prescribed under Rule 68-T and 102 )</h3>
    <h2>(Certificate of Fitness of employment in hazardous process and operations)</h2>
    <h3>( TO BE ISSUED BY FACTORY MEDICAL OFFICER )</h3>

    <!-- Employee Information -->
    <table>
        <tbody>
            <tr>
                <td><strong>1. Serial number in the register of adult workers:</strong></td>
                <td>{{ $product->EmployeeNo }}</td>
            </tr>

            <tr>
                <td><strong>2. Name of the person examined:</strong></td>
                <td>{{ $product->EmployeeName }}</td>
            </tr>

            <tr>
                <td><strong>3. Father's Name:</strong></td>
                <td>{{ $product->FathersName }}</td>
            </tr>

            <tr>
                <td><strong>4. Sex:</strong></td>
                <td>{{ ucfirst($product->Sex) }}</td>
            </tr>

            <tr>
                <td><strong>5. Date of Birth / Age:</strong></td>
                <td>
                    {{ \Carbon\Carbon::parse($product->DateOfBirth)->format('d-m-Y') }}
                    ( {{ \Carbon\Carbon::parse($product->DateOfBirth)->age }} Years )
                </td>
            </tr>



            <tr>
                <td><strong>6. Residence:</strong></td>
                <td>{{ $product->Address }}</td>
            </tr>

            <tr>
                <td><strong>7. Name & address of the factory:</strong></td>
                <td>{{ $product->Company }}</td>
            </tr>

            <tr>
                <td><strong>8. The worker is employed / proposed:</strong></td>
                <td>{{ $product->Department }}</td>
            </tr>

            <tr>
                <td><strong> (a) Hazardous process:</strong> </td>
                <td>{{ $product->HazardousProcess }}</td>
            </tr>

            <tr>
                <td><strong> (b) Dangerous operation:</strong></td>
                <td>{{ $product->DangerousOperation }}</td>
            </tr>
        </tbody>
    </table>


    <!-- Certification Statement -->
    <table>
        <tbody>
            <tr>
                <td colspan="4">
                    I certify that I have personally examined the above-named person whose identification mark is
                    <b>{{ $product->IdentificationMark }}</b> and who is desirous of being employed in the
                    above-mentioned process/operation. In my opinion, he/she is fit for employment in the said
                    manufacturing process/operation. and that his/her, age, as can be ascertained from my examination,
                    is <b>{{ \Carbon\Carbon::parse($product->DateOfBirth)->age }}</b> years.
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    In my opinion, he/she is fit for employment in the said manufacturing process/operation for the
                    reason:

                </td>
            </tr>
            <tr>
                <td colspan="4">
                    In my opinion, he/she is unfit for employment in the said manufacturing process/operation for the
                    reason:
                    {{ $product->ReasonUnfit }}
                </td>
            </tr>

        </tbody>
    </table>

    <h3 style="text-align: left;">
        The serial number of previous certificate is: {{ $product->PreviousCertificateNo }}
    </h3>


    <!-- Signature Section -->
    <table>
        <tbody>
            <tr>
                <td style="width: 25%;"><strong>Signature/Left Thumb:</strong></td>
                <td style="width: 25%;">{{ $product->EmployeeSignature }}</td><br><br><br><br>
                <td style="width: 25%;"><strong>Signature of Factory Medical Officer:</strong></td>
                <td style="width: 25%;">{{ $product->DoctorSignature }}</td>
            </tr>
            <tr>
                <td><strong>Impression of Person Examined:</strong></td>
                <td>{{ $product->EmployeeImpression }}</td><br><br><br><br><br>
                <td><strong>Stamp of Factory Medical Officer With name of the Factory:</strong></td>
                <td>{{ $product->DoctorStamp }}</td>
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


        <tbody>
            <tr>

                <td>I certify that
                    I examined the person
                    mentioned above on</td>
                <td>I extend this certificate untill (if
                    certificate Is not extended the, period
                    for which the worker is considered
                    unfit for work is to be mentioned)</td>
                <td>Sign and symptoms
                    observed during
                    examination</td>
                <td>Signature of the
                    Factory Medical Officer
                    with date</td>
            </tr>

            <tr>

                <td>{{ \Carbon\Carbon::parse($product->DateOfExamination)->format('d-m-Y') }}</td>

                <td>{{ \Carbon\Carbon::parse($product->DateOfExamination)->format('d-m-Y') }}</td>

                <td>{{ $product->DoctorsRemarks }}</td>
                <td>{{ $product->NameOfDoctor }}<br>{{ $product->DoctorSignature }}</td>

            </tr>
        </tbody>
    </table>

</body>

</html>