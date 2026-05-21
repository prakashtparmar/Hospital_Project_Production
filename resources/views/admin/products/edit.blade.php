@extends('layouts.app')

@section('title', 'Edit Employee Health Record')

@section('breadcrumbs')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('products.index') }}">Employee Health Record</a>
        </li>
        <li class="active">Edit Record</li>
    </ul>
</div>
@endsection

@section('content')

<div class="page-header">
    <h4 class="page-title">
        Employee Health Record
        <small><i class="ace-icon fa fa-angle-double-right"></i> Edit Health Record</small>

        <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </h4>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.
    <ul class="mt-2">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('products.update', $product->id) }}" method="POST">
@csrf
@method('PUT')

<table class="table table-bordered table-striped">

{{-- ================= 1. EMPLOYEE INFORMATION ================= --}}
<thead class="thead-dark">
<tr><th colspan="4">1. Employee Information</th></tr>
</thead>
<tbody>
<tr>
    <td>Employee No</td>
    <td><input name="EmployeeNo" class="form-control" value="{{ old('EmployeeNo',$product->EmployeeNo) }}"></td>
    <td>Employee Name</td>
    <td><input name="EmployeeName" class="form-control" value="{{ old('EmployeeName',$product->EmployeeName) }}"></td>
</tr>

<tr>
    <td>Date of Birth</td>
    <td><input type="date" name="DateOfBirth" class="form-control" value="{{ old('DateOfBirth',$product->DateOfBirth) }}"></td>
    <td>Sex</td>
    <td>
        <select name="Sex" class="form-control">
            <option value="">Select</option>
            <option value="male" {{ old('Sex',$product->Sex)=='male'?'selected':'' }}>Male</option>
            <option value="female" {{ old('Sex',$product->Sex)=='female'?'selected':'' }}>Female</option>
        </select>
    </td>
</tr>

<tr>
    <td>Identification Mark</td>
    <td colspan="3">
        <textarea name="IdentificationMark" class="form-control">{{ old('IdentificationMark',$product->IdentificationMark) }}</textarea>
    </td>
</tr>

<tr>
    <td>Father's Name</td>
    <td><input name="FathersName" class="form-control" value="{{ old('FathersName',$product->FathersName) }}"></td>
    <td>Marital Status</td>
    <td>
        <select name="MaritalStatus" class="form-control">
            @foreach(['Married','Unmarried','Single','NA'] as $s)
            <option value="{{ $s }}" {{ old('MaritalStatus',$product->MaritalStatus)==$s?'selected':'' }}>{{ $s }}</option>
            @endforeach
        </select>
    </td>
</tr>

<tr>
    <td>Husband's Name</td>
    <td><input name="HusbandsName" class="form-control" value="{{ old('HusbandsName',$product->HusbandsName) }}"></td>
    <td>Address</td>
    <td><textarea name="Address" class="form-control">{{ old('Address',$product->Address) }}</textarea></td>
</tr>

<tr>
    <td>Dependent</td>
    <td><input name="Dependent" class="form-control" value="{{ old('Dependent',$product->Dependent) }}"></td>
    <td>Mobile</td>
    <td><input name="Mobile" class="form-control" value="{{ old('Mobile',$product->Mobile) }}"></td>
</tr>

<tr>
    <td>Joining Date</td>
    <td><input type="date" name="JoiningDate" class="form-control" value="{{ old('JoiningDate',$product->JoiningDate) }}"></td>
    <td>Date of Examination</td>
    <td><input type="date" name="DateOfExamination" class="form-control" value="{{ old('DateOfExamination',$product->DateOfExamination) }}"></td>
</tr>
</tbody>

{{-- ================= 2. COMPANY & JOB ================= --}}
<thead class="thead-dark"><tr><th colspan="4">2. Company & Job Details</th></tr></thead>
<tbody>
<tr>
    <td>Company</td>
    <td><textarea name="Company" class="form-control">{{ old('Company',$product->Company) }}</textarea></td>
    <td>Department</td>
    <td><input name="Department" class="form-control" value="{{ old('Department',$product->Department) }}"></td>
</tr>
<tr>
    <td>Designation</td>
    <td><input name="Designation" class="form-control" value="{{ old('Designation',$product->Designation) }}"></td>
    <td>H/O Habit</td>
    <td><textarea name="H_OHabit" class="form-control">{{ old('H_OHabit',$product->H_OHabit) }}</textarea></td>
</tr>
<tr>
    <td>Previous Occupational History</td>
    <td colspan="3"><textarea name="Prev_Occ_History" class="form-control">{{ old('Prev_Occ_History',$product->Prev_Occ_History) }}</textarea></td>
</tr>
</tbody>

{{-- ================= 3–11 ALL OTHER SECTIONS (UNCHANGED) ================= --}}
@php
$sections = [
    '3. Physical Examination'=>['Temperature','Height','ChestBeforeBreathing','Pulse','Weight','ChestAfterBreathing','BP','BMI','SpO2','RespirationRate'],
    '4. Vision'=>['RightEyeSpecs','LeftEyeSpecs','NearVisionRight','NearVisionLeft','DistantVisionRight','DistantVisionLeft','ColourVision'],
    '5. ENT & Systemic'=>['Eye','Nose','Conjunctiva','Ear','Tongue','Nails','Throat','Skin','Teeth','PEFR'],
    '6. Clinical Signs'=>['Eczema','Cyanosis','Jaundice','Anaemia','Oedema','Clubbing','Allergy','Lymphnode'],
    '7. Medical History'=>['KnownHypertension','Diabetes','Dyslipidemia','RadiationEffect','Vertigo','Tuberculosis','ThyroidDisorder','Epilepsy','Br_Asthma','HeartDisease','PresentComplain'],
    '8. Systemic Examination'=>['RespirationSystem','GenitoUrinary','CVS','CNS','PerAbdomen','ENT'],
    '9. Investigations'=>['PFT','XRayChest','VertigoTest','Audiometry','ECG'],
    '10. Lab'=>['HB','WBC','Paasite','RBC','Platelet','ESR','FBS','PP2BS','SGPT','SCreatintine','RBS','SChol','STRG','SHDL','SLDL','CHRatio'],
    '11. Urine'=>['UrineColour','UrineReaction','UrineAlbumin','UrineSugar','UrinePusCell','UrineRBC','UrineEpiCell','UrineCrystal']
];
@endphp

@foreach($sections as $title=>$fields)
<thead class="thead-dark"><tr><th colspan="4">{{ $title }}</th></tr></thead>
<tbody>
@foreach($fields as $f)
<tr>
    <td>{{ $f }}</td>
    <td colspan="3"><input name="{{ $f }}" class="form-control" value="{{ old($f,$product->$f) }}"></td>
</tr>
@endforeach
</tbody>
@endforeach

{{-- ================= 12. DOCTOR & HAZARD ================= --}}
<thead class="thead-dark"><tr><th colspan="4">12. Doctor & Hazard</th></tr></thead>
<tbody>
<tr>
    <td>Doctor</td>
    <td><input name="NameOfDoctor" class="form-control" value="{{ old('NameOfDoctor',$product->NameOfDoctor) }}"></td>
    <td>Signature</td>
    <td><input name="DoctorSignature" class="form-control" value="{{ old('DoctorSignature',$product->DoctorSignature) }}"></td>
</tr>
<tr>
    <td>Reviewed By</td>
    <td><input name="ReviewedBy" class="form-control" value="{{ old('ReviewedBy',$product->ReviewedBy) }}"></td>
    <td>Remarks</td>
    <td><textarea name="DoctorsRemarks" class="form-control">{{ old('DoctorsRemarks',$product->DoctorsRemarks) }}</textarea></td>
</tr>
<tr>
    <td>Health Status</td>
    <td colspan="3"><input name="HealthStatus" class="form-control" value="{{ old('HealthStatus',$product->HealthStatus) }}"></td>
</tr>

@foreach(['HazardousProcess','DangerousOperation','Rawmaterials','JobRestriction'] as $f)
<tr>
    <td>{{ $f }}</td>
    <td colspan="3"><textarea name="{{ $f }}" class="form-control">{{ old($f,$product->$f) }}</textarea></td>
</tr>
@endforeach
</tbody>

<tfoot>
<tr>
    <td colspan="4" class="text-center">
        <button class="btn btn-success btn-sm">
            <i class="fa fa-save"></i> Update Record
        </button>
    </td>
</tr>
</tfoot>

</table>
</form>

@endsection
