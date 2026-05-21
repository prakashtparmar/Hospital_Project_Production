@extends('layouts.app')

@section('title', 'Create Health Record')

@section('breadcrumbs')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('products.index') }}">Employe Health Record</a>
            </li>
            <li class="active">Create Health Record</li>
        </ul>
    </div>
@endsection

@section('content')

    <div class="page-header">
        <h4 class="page-title">
            Employe Health Record
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Create New Health Record
            </small>

            <a class="btn btn-primary btn-sm pull-right" href="{{ route('products.index') }}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </h4>
    </div>

    <div class="row">
        <div class="col-xs-12">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ===================== FORM START (UNCHANGED) ===================== --}}
            <form action="{{ route('products.store') }}" method="POST">
                @csrf



                <table class="table table-bordered table-striped">

                    {{-- Section 1: Employee Information --}}
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="4">1. Employee Information</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1 Employee No</td>
                            <td><input type="text" name="EmployeeNo" class="form-control" value="{{ old('EmployeeNo') }}">
                            </td>
                            <td>2 Employee Name</td>
                            <td><input type="text" name="EmployeeName" class="form-control"
                                    value="{{ old('EmployeeName') }}"></td>
                        </tr>
                        <tr>
                            <td>3 Date of Birth</td>
                            <td><input type="date" name="DateOfBirth" class="form-control" value="{{ old('DateOfBirth') }}">
                            </td>
                            <td>4 Sex</td>
                            <td>
                                <select name="Sex" class="form-control">
                                    <option value="">Select</option>
                                    <option value="male" {{ old('Sex') == 'male' ? 'selected' : '' }}>Male
                                    </option>
                                    <option value="female" {{ old('Sex') == 'female' ? 'selected' : '' }}>
                                        Female</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>5 Identification Mark</td>
                            <td colspan="3"><textarea name="IdentificationMark"
                                    class="form-control">{{ old('IdentificationMark') }}</textarea></td>
                        </tr>
                        <tr>
                            <td>6 Father's Name</td>
                            <td><input type="text" name="FathersName" class="form-control" value="{{ old('FathersName') }}">
                            </td>
                            <td>7 Marital Status</td>
                            <td>
                                <select name="MaritalStatus" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Married" {{ old('MaritalStatus') == 'Married' ? 'selected' : '' }}>Married
                                    </option>
                                    <option value="Unmarried" {{ old('MaritalStatus') == 'Unmarried' ? 'selected' : '' }}>
                                        Unmarried</option>
                                    <option value="Single" {{ old('MaritalStatus') == 'Single' ? 'selected' : '' }}>Single
                                    </option>
                                    <option value="NA" {{ old('MaritalStatus') == 'NA' ? 'selected' : '' }}>NA</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>8 Husband's Name</td>
                            <td><input type="text" name="HusbandsName" class="form-control"
                                    value="{{ old('HusbandsName') }}"></td>
                            <td>9 Address</td>
                            <td><textarea name="Address" class="form-control">{{ old('Address') }}</textarea></td>
                        </tr>
                        <tr>
                            <td>10 Dependent</td>
                            <td><input type="text" name="Dependent" class="form-control" value="{{ old('Dependent') }}">
                            </td>
                            <td>11 Mobile</td>
                            <td><input type="text" name="Mobile" class="form-control" pattern="[0-9]{10}"
                                    value="Mobile number must be 10 digits." required></td>
                        </tr>
                        <tr>
                            <!-- <td>12 Joining Date</td>
                                                <td><input type="date" name="JoiningDate" class="form-control" value="{{ old('JoiningDate') }}"></td> -->


                            <td>12. Joining Date</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <input type="date" name="JoiningDate" class="form-control me-2"
                                        value="{{ old('JoiningDate') }}">
                                    <label class="ms-2">
                                        <input type="checkbox" name="JoiningDateNA" value="NA" {{ old('JoiningDate') ? '' : 'checked' }}> N/A
                                    </label>
                                </div>
                            </td>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const dateInput = document.querySelector('input[name="JoiningDate"]');
                                    const naCheckbox = document.querySelector('input[name="JoiningDateNA"]');

                                    // Initialize disabled state on page load
                                    if (naCheckbox.checked) {
                                        dateInput.disabled = true;
                                        dateInput.value = '';
                                    }

                                    // When date changes, uncheck N/A and enable input
                                    dateInput.addEventListener('change', function () {
                                        if (this.value) {
                                            naCheckbox.checked = false;
                                            dateInput.disabled = false;
                                        }
                                    });

                                    // When N/A is checked, clear and disable date input
                                    naCheckbox.addEventListener('change', function () {
                                        if (this.checked) {
                                            dateInput.value = '';
                                            dateInput.disabled = true;
                                        } else {
                                            dateInput.disabled = false;
                                        }
                                    });
                                });
                            </script>






                            <td>13 Date of Examination</td>
                            <td><input type="date" name="DateOfExamination" class="form-control"
                                    value="{{ old('DateOfExamination') }}"></td>
                        </tr>
                    </tbody>

                    {{-- Section 2: Company & Job Details --}}
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="4">2. Company & Job Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>14 Company</td>
                            <td><textarea name="Company" class="form-control">{{ old('Company') }}</textarea></td>
                            <td>15 Department</td>
                            <td><input type="text" name="Department" class="form-control" value="{{ old('Department') }}">
                            </td>
                        </tr>
                        <tr>
                            <td>16 Designation</td>
                            <td><input type="text" name="Designation" class="form-control" value="{{ old('Designation') }}">
                            </td>
                            <td>17 H/O Habit</td>
                            <td><textarea name="H_OHabit" class="form-control">{{ old('H_OHabit') }}</textarea></td>
                        </tr>
                        <tr>
                            <td>18 Previous Occupational History</td>
                            <td colspan="3"><textarea name="Prev_Occ_History"
                                    class="form-control">{{ old('Prev_Occ_History') }}</textarea></td>
                        </tr>
                    </tbody>

                    {{-- Section 3: Physical Examination --}}
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="4">3. Physical Examination</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>19 Temperature (F)</td>
                            <td><input type="text" name="Temperature" class="form-control" value="{{ old('Temperature') }}">
                            </td>
                            <td>20 Height(cm)</td>
                            <td><input type="text" name="Height" class="form-control" value="{{ old('Height') }}"></td>
                        </tr>
                        <tr>
                            <td>21 Chest Before Breathing(cm)</td>
                            <td><input type="text" name="ChestBeforeBreathing" class="form-control"
                                    value="{{ old('ChestBeforeBreathing') }}"></td>
                            <td>22 Pulse(per Minute)</td>
                            <td><input type="text" name="Pulse" class="form-control" value="{{ old('Pulse') }}"></td>
                        </tr>
                        <tr>
                            <td>23 Weight(kg)</td>
                            <td><input type="text" name="Weight" class="form-control" value="{{ old('Weight') }}"></td>
                            <td>24 Chest After Breathing(cm)</td>
                            <td><input type="text" name="ChestAfterBreathing" class="form-control"
                                    value="{{ old('ChestAfterBreathing') }}"></td>
                        </tr>
                        <tr>
                            <td>25 BP(mmHg)</td>
                            <td><input type="text" name="BP" class="form-control" value="{{ old('BP') }}"></td>
                            <td>26 BMI</td>
                            <td><input type="text" name="BMI" class="form-control" value="{{ old('BMI') }}"></td>
                        </tr>
                        <tr>
                            <td>27 SpO2(%)</td>
                            <td><input type="text" name="SpO2" class="form-control" value="{{ old('SpO2') }}"></td>
                            <td>28 Respiration Rate</td>
                            <td><input type="text" name="RespirationRate" class="form-control"
                                    value="{{ old('RespirationRate') }}"></td>
                        </tr>
                    </tbody>

                    {{-- Section 4: Vision --}}
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="4">4. Vision</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>29 Right Eye Specs</td>
                            <td><input type="text" name="RightEyeSpecs" class="form-control" value="Normal"></td>
                            <td>30 Left Eye Specs</td>
                            <td><input type="text" name="LeftEyeSpecs" class="form-control" value="Normal"></td>
                        </tr>
                        <tr>
                            <td>31 Near Vision (Right)</td>
                            <td><input type="text" name="NearVisionRight" class="form-control" value="N/6"></td>
                            <td>32 Near Vision (Left)</td>
                            <td><input type="text" name="NearVisionLeft" class="form-control" value="N/6"></td>
                        </tr>
                        <tr>
                            <td>33 Distant Vision (Right)</td>
                            <td><input type="text" name="DistantVisionRight" class="form-control" value="6/6"></td>
                            <td>34 Distant Vision (Left)</td>
                            <td><input type="text" name="DistantVisionLeft" class="form-control" value="6/6"></td>
                        </tr>
                        <tr>
                            <td>35 Colour Vision</td>
                            <td colspan="3"><input type="text" name="ColourVision" class="form-control" value="Normal"></td>
                        </tr>
                    </tbody>

                    {{-- Section 5: ENT & Systemic Examination --}}
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="4">5. ENT & Systemic Examination</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- General Examination -->
                        <tr class="table-primary">
                            <td colspan="3"><strong>5. General Examination</strong></td>
                        </tr>
                        <tr>
                            <td>5.1 Eye</td>
                            <td><input type="text" name="Eye" class="form-control" value="{{ old('Eye', 'Normal') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>5.2 Nose</td>
                            <td><input type="text" name="Nose" class="form-control" value="{{ old('Nose', 'Normal') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>5.3 Conjunctiva</td>
                            <td><input type="text" name="Conjunctiva" class="form-control"
                                    value="{{ old('Conjunctiva', 'Normal') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>5.4 Ear</td>
                            <td><input type="text" name="Ear" class="form-control" value="{{ old('Ear', 'Normal') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>5.5 Tongue</td>
                            <td><input type="text" name="Tongue" class="form-control" value="{{ old('Tongue', 'Normal') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>5.6 Nails</td>
                            <td><input type="text" name="Nails" class="form-control" value="{{ old('Nails', 'Normal') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>5.7 Throat</td>
                            <td><input type="text" name="Throat" class="form-control" value="{{ old('Throat', 'Normal') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>5.8 Skin</td>
                            <td><input type="text" name="Skin" class="form-control" value="{{ old('Skin', 'Normal') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>5.9 Teeth</td>
                            <td><input type="text" name="Teeth" class="form-control" value="{{ old('Teeth', 'Normal') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>6.0 PEFR</td>
                            <td><input type="text" name="PEFR" class="form-control" value="{{ old('PEFR', ) }}"></td>
                            <td colspan="2"></td>
                        </tr>

                        <!-- Clinical Signs -->
                        <tr class="table-primary">
                            <td colspan="3"><strong>6. Clinical Signs</strong></td>
                        </tr>
                        <tr>
                            <td>6.1 Eczema</td>
                            <td><input type="text" name="Eczema" class="form-control" value="{{ old('Eczema', 'No') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>6.2 Cyanosis</td>
                            <td><input type="text" name="Cyanosis" class="form-control" value="{{ old('Cyanosis', 'No') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>6.3 Jaundice</td>
                            <td><input type="text" name="Jaundice" class="form-control" value="{{ old('Jaundice', 'No') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>6.4 Anaemia</td>
                            <td><input type="text" name="Anaemia" class="form-control" value="{{ old('Anaemia', 'No') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>6.5 Oedema</td>
                            <td><input type="text" name="Oedema" class="form-control" value="{{ old('Oedema', 'No') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>6.6 Clubbing</td>
                            <td><input type="text" name="Clubbing" class="form-control" value="{{ old('Clubbing', 'No') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>6.7 Allergy</td>
                            <td><input type="text" name="Allergy" class="form-control" value="{{ old('Allergy', 'No') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>6.8 Lymphnode</td>
                            <td><input type="text" name="Lymphnode" class="form-control"
                                    value="{{ old('Lymphnode', 'No') }}"></td>
                            <td colspan="2"></td>
                        </tr>

                        <!-- Medical History -->
                        <tr class="table-primary">
                            <td colspan="3"><strong>7. Medical History</strong></td>
                        </tr>
                        <tr>
                            <td>6.9 Known Hypertension</td>
                            <td><input type="text" name="KnownHypertension" class="form-control"
                                    value="{{ old('KnownHypertension', 'No') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>7.0 Diabetes</td>
                            <td><input type="text" name="Diabetes" class="form-control" value="{{ old('Diabetes', 'No') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>7.1 Dyslipidemia</td>
                            <td><input type="text" name="Dyslipidemia" class="form-control"
                                    value="{{ old('Dyslipidemia', 'No') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>7.2 Radiation Effect</td>
                            <td><input type="text" name="RadiationEffect" class="form-control"
                                    value="{{ old('RadiationEffect', 'No') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>7.3 Vertigo</td>
                            <td><input type="text" name="Vertigo" class="form-control" value="{{ old('Vertigo', 'No') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>7.4 Tuberculosis</td>
                            <td><input type="text" name="Tuberculosis" class="form-control"
                                    value="{{ old('Tuberculosis', 'No') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>7.5 Thyroid Disorder</td>
                            <td><input type="text" name="ThyroidDisorder" class="form-control"
                                    value="{{ old('ThyroidDisorder', 'No') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>7.6 Epilepsy</td>
                            <td><input type="text" name="Epilepsy" class="form-control" value="{{ old('Epilepsy', 'No') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>7.7 Br Asthma</td>
                            <td><input type="text" name="Br_Asthma" class="form-control"
                                    value="{{ old('Br_Asthma', 'No') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>7.8 Heart Disease</td>
                            <td><input type="text" name="HeartDisease" class="form-control"
                                    value="{{ old('HeartDisease', 'No') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>7.9 Present Complain</td>
                            <td><input type="text" name="PresentComplain" class="form-control"
                                    value="{{ old('PresentComplain', 'No') }}"></td>
                            <td colspan="2"></td>
                        </tr>

                        <!-- Systemic Examination -->
                        <tr class="table-primary">
                            <td colspan="3"><strong>8. Systemic Examination</strong></td>
                        </tr>
                        <tr>
                            <td>8.0 Respiration System</td>
                            <td><input type="text" name="RespirationSystem" class="form-control"
                                    value="{{ old('RespirationSystem', 'Air Entry Bilateral Equal, No Creps/Rhonchi') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>8.1 Genito Urinary</td>
                            <td><input type="text" name="GenitoUrinary" class="form-control"
                                    value="{{ old('GenitoUrinary', 'Normal') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>8.2 CVS</td>
                            <td><input type="text" name="CVS" class="form-control"
                                    value="{{ old('CVS', 'S1,S2-Normal,No Murmur') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>8.3 CNS</td>
                            <td><input type="text" name="CNS" class="form-control" value="{{ old('CNS', 'Normal') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>8.4 Per Abdomen</td>
                            <td><input type="text" name="PerAbdomen" class="form-control"
                                    value="{{ old('PerAbdomen', 'Soft Spleen,Liver, Not Palpable') }}">
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>8.5 ENT</td>
                            <td><input type="text" name="ENT" class="form-control" value="{{ old('ENT', 'NAD') }}"></td>
                            <td colspan="2"></td>
                        </tr>

                        <!-- Investigations -->
                        <tr class="table-primary">
                            <td colspan="3"><strong>9. Investigations</strong></td>
                        </tr>
                        <tr>
                            <td>8.6 PFT</td>
                            <td><input type="text" name="PFT" class="form-control" value="{{ old('PFT', 'Normal') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>8.7 XRay Chest</td>
                            <td><input type="text" name="XRayChest" class="form-control"
                                    value="{{ old('XRayChest', 'Normal') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>8.8 Vertigo Test</td>
                            <td><input type="text" name="VertigoTest" class="form-control"
                                    value="{{ old('VertigoTest', 'Normal') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>8.9 Audiometry</td>
                            <td><input type="text" name="Audiometry" class="form-control"
                                    value="{{ old('Audiometry', 'Normal') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>9.0 ECG</td>
                            <td><input type="text" name="ECG" class="form-control" value="{{ old('ECG', 'Normal') }}"></td>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>



                    {{-- Section 6: Family History --}}
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="4">6. Family History</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['Father', 'Mother', 'Brother', 'Sister'] as $index => $field)
                            <tr>
                                <td>{{ 6.1 + $index }} {{ $field }}</td>
                                <td><input type="text" name="{{ $field }}" class="form-control" value="{{ old($field) }}"></td>
                                <td colspan="2"></td>
                            </tr>
                        @endforeach
                    </tbody>

                    {{-- Section 7: Lab Investigations --}}
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="4">7. Lab Investigations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['HB', 'WBC', 'Paasite', 'RBC', 'Platelet', 'ESR', 'FBS', 'PP2BS', 'SGPT', 'SCreatintine', 'RBS', 'SChol', 'STRG', 'SHDL', 'SLDL', 'CHRatio'] as $index => $field)
                            <tr>
                                <td>{{ 7.1 + $index }} {{ $field }}</td>
                                <td><input type="text" name="{{ $field }}" class="form-control" value="{{ old($field) }}"></td>
                                <td colspan="2"></td>
                            </tr>
                        @endforeach
                    </tbody>

                    {{-- Section 8: Urine Analysis --}}
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="4">8. Urine Analysis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['UrineColour', 'UrineReaction', 'UrineAlbumin', 'UrineSugar', 'UrinePusCell', 'UrineRBC', 'UrineEpiCell', 'UrineCrystal'] as $index => $field)
                            <tr>
                                <td>{{ 8.1 + $index }} {{ $field }}</td>
                                <td><input type="text" name="{{ $field }}" class="form-control" value="{{ old($field) }}"></td>
                                <td colspan="2"></td>
                            </tr>
                        @endforeach
                    </tbody>

                    {{-- Section 9: Doctor & Remarks --}}
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="4">9. Doctor & Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>9.1 Name of Doctor</td>
                            <td><input type="text" name="NameOfDoctor" class="form-control"
                                    value="{{ old('NameOfDoctor') }}"></td>
                            <td>9.2 Doctor Signature</td>
                            <td><input type="text" name="DoctorSignature" class="form-control"
                                    value="{{ old('DoctorSignature') }}"></td>
                        </tr>
                        <tr>
                            <td>9.3 Reviewed By</td>
                            <td><input type="text" name="ReviewedBy" class="form-control" value="{{ old('ReviewedBy') }}">
                            </td>
                            <td>9.4 Doctors Remarks</td>
                            <td><textarea name="DoctorsRemarks" class="form-control">{{ old('DoctorsRemarks') }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>9.5 Health Status</td>
                            <td><input type="text" name="HealthStatus" class="form-control"
                                    value="{{ old('HealthStatus') }}"></td>

                        </tr>
                    </tbody>

                    {{-- Section 10: HazardousProcess & Dangerous Info --}}
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="4">10. HazardousProcess & Dangerous Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['HazardousProcess', 'DangerousOperation', 'Rawmaterials', 'JobRestriction'] as $index => $field)
                            <tr>
                                <td>{{ 10.1 + $index }} {{ $field }}</td>
                                <td colspan="3"><textarea name="{{ $field }}" class="form-control">{{ old($field) }}</textarea>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3">
                                    <i class="fa fa-floppy-o"></i> Submit
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
            {{-- ===================== FORM END ===================== --}}

        </div>
    </div>

@endsection

@push('scripts')
    {{-- ✅ SAME JS (UNCHANGED) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dateInput = document.querySelector('input[name="JoiningDate"]');
            const naCheckbox = document.querySelector('input[name="JoiningDateNA"]');

            if (naCheckbox && naCheckbox.checked) {
                dateInput.disabled = true;
                dateInput.value = '';
            }

            dateInput?.addEventListener('change', function () {
                if (this.value) {
                    naCheckbox.checked = false;
                    dateInput.disabled = false;
                }
            });

            naCheckbox?.addEventListener('change', function () {
                if (this.checked) {
                    dateInput.value = '';
                    dateInput.disabled = true;
                } else {
                    dateInput.disabled = false;
                }
            });
        });
    </script>
@endpush