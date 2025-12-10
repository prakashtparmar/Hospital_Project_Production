@extends('layouts.app')

@section('title', 'View Employee Health Record')

@push('styles')
<style>
@media print {
    #sidebar, #navbar, .breadcrumbs, .btn,
    #btn-scroll-up, .page-header a.btn,
    .ace-save-state {
        display: none !important;
    }

    .main-content {
        position: absolute !important;
        left: 0;
        top: 0;
        width: 100%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    th, td {
        border: 1px solid #000;
        padding: 6px;
    }

    thead.thead-dark th {
        background: #ddd !important;
        -webkit-print-color-adjust: exact;
    }
}
</style>
@endpush

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li><a href="{{ route('products.index') }}">Employee Health Record</a></li>
        <li class="active">View Record</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">
        Employee Health Record
        <small><i class="ace-icon fa fa-angle-double-right"></i> View</small>

        @can('product-print')
        <button class="btn btn-success btn-sm pull-right"
            onclick="window.open('{{ route('products.pdf', $product->id) }}','_blank')">
            <i class="fa fa-file-pdf-o"></i> Print / PDF
        </button>
        @endcan

        <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </h4>
</div>

<div class="row">
<div class="col-xs-12">

<table class="table table-bordered table-striped">

{{-- ================= 1. EMPLOYEE INFORMATION ================= --}}
<thead class="thead-dark"><tr><th colspan="4">1. Employee Information</th></tr></thead>
<tbody>
<tr><td>Employee No</td><td>{{ $product->EmployeeNo }}</td><td>Name</td><td>{{ $product->EmployeeName }}</td></tr>
<tr><td>DOB</td><td>{{ $product->DateOfBirth }}</td><td>Sex</td><td>{{ ucfirst($product->Sex) }}</td></tr>
<tr><td>Identification</td><td colspan="3">{{ $product->IdentificationMark }}</td></tr>
<tr><td>Father</td><td>{{ $product->FathersName }}</td><td>Marital</td><td>{{ $product->MaritalStatus }}</td></tr>
<tr><td>Husband</td><td>{{ $product->HusbandsName }}</td><td>Address</td><td>{{ $product->Address }}</td></tr>
<tr><td>Dependent</td><td>{{ $product->Dependent }}</td><td>Mobile</td><td>{{ $product->Mobile }}</td></tr>
<tr><td>Joining Date</td><td>{{ $product->JoiningDate ?? 'N/A' }}</td><td>Exam Date</td><td>{{ $product->DateOfExamination }}</td></tr>
</tbody>

{{-- ================= 2. COMPANY DETAILS ================= --}}
<thead class="thead-dark"><tr><th colspan="4">2. Company & Job Details</th></tr></thead>
<tbody>
<tr><td>Company</td><td>{{ $product->Company }}</td><td>Department</td><td>{{ $product->Department }}</td></tr>
<tr><td>Designation</td><td>{{ $product->Designation }}</td><td>H/O Habit</td><td>{{ $product->H_OHabit }}</td></tr>
<tr><td>Previous History</td><td colspan="3">{{ $product->Prev_Occ_History }}</td></tr>
</tbody>

{{-- ================= 3. PHYSICAL ================= --}}
<thead class="thead-dark"><tr><th colspan="4">3. Physical Examination</th></tr></thead>
<tbody>
@foreach([
'Temperature','Height','ChestBeforeBreathing','Pulse','Weight',
'ChestAfterBreathing','BP','BMI','SpO2','RespirationRate'
] as $f)
<tr><td>{{ $f }}</td><td>{{ $product->$f }}</td><td colspan="2"></td></tr>
@endforeach
</tbody>

{{-- ================= 4. VISION ================= --}}
<thead class="thead-dark"><tr><th colspan="4">4. Vision</th></tr></thead>
<tbody>
@foreach([
'RightEyeSpecs','LeftEyeSpecs','NearVisionRight','NearVisionLeft',
'DistantVisionRight','DistantVisionLeft','ColourVision'
] as $f)
<tr><td>{{ $f }}</td><td>{{ $product->$f }}</td><td colspan="2"></td></tr>
@endforeach
</tbody>

{{-- ================= 5. ENT ================= --}}
<thead class="thead-dark"><tr><th colspan="4">5. ENT & General</th></tr></thead>
<tbody>
@foreach(['Eye','Nose','Conjunctiva','Ear','Tongue','Nails','Throat','Skin','Teeth','PEFR'] as $f)
<tr><td>{{ $f }}</td><td>{{ $product->$f }}</td><td colspan="2"></td></tr>
@endforeach
</tbody>

{{-- ================= 6. CLINICAL ================= --}}
<thead class="thead-dark"><tr><th colspan="4">6. Clinical Signs</th></tr></thead>
<tbody>
@foreach(['Eczema','Cyanosis','Jaundice','Anaemia','Oedema','Clubbing','Allergy','Lymphnode'] as $f)
<tr><td>{{ $f }}</td><td>{{ $product->$f }}</td><td colspan="2"></td></tr>
@endforeach
</tbody>

{{-- ================= 7. MEDICAL HISTORY ================= --}}
<thead class="thead-dark"><tr><th colspan="4">7. Medical History</th></tr></thead>
<tbody>
@foreach(['KnownHypertension','Diabetes','Dyslipidemia','RadiationEffect','Vertigo','Tuberculosis','ThyroidDisorder','Epilepsy','Br_Asthma','HeartDisease','PresentComplain'] as $f)
<tr><td>{{ $f }}</td><td>{{ $product->$f }}</td><td colspan="2"></td></tr>
@endforeach
</tbody>

{{-- ================= 8. SYSTEMIC ================= --}}
<thead class="thead-dark"><tr><th colspan="4">8. Systemic Examination</th></tr></thead>
<tbody>
@foreach(['RespirationSystem','GenitoUrinary','CVS','CNS','PerAbdomen','ENT'] as $f)
<tr><td>{{ $f }}</td><td>{{ $product->$f }}</td><td colspan="2"></td></tr>
@endforeach
</tbody>

{{-- ================= 9. LAB ================= --}}
<thead class="thead-dark"><tr><th colspan="4">9. Lab Investigations</th></tr></thead>
<tbody>
@foreach(['HB','WBC','RBC','Platelet','ESR','FBS','PP2BS','SGPT','SCreatintine','RBS','SChol','STRG','SHDL','SLDL','CHRatio'] as $f)
<tr><td>{{ $f }}</td><td>{{ $product->$f }}</td><td colspan="2"></td></tr>
@endforeach
</tbody>

{{-- ================= 10. DOCTOR & HAZARD ================= --}}
<thead class="thead-dark"><tr><th colspan="4">10. Doctor & Hazard</th></tr></thead>
<tbody>
<tr><td>Doctor</td><td>{{ $product->NameOfDoctor }}</td><td>Signature</td><td>{{ $product->DoctorSignature }}</td></tr>
<tr><td>Remarks</td><td colspan="3">{{ $product->DoctorsRemarks }}</td></tr>
<tr><td>Hazardous</td><td colspan="3">{{ $product->Hazardous }}</td></tr>
<tr><td>Job Restriction</td><td colspan="3">{{ $product->JobRestriction }}</td></tr>
</tbody>

</table>

</div>
</div>

@endsection
