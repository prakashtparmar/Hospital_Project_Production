<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    LabTestCategory,
    LabTest,
    LabTestParameter,
    LabTestRequest,
    LabTestRequestItem,
    LabTestResult,
    Patient,
    User
};

class LabModuleSeeder extends Seeder
{
    public function run()
    {
        /*
        |--------------------------------------------------------------------------
        | 1. LAB TEST CATEGORIES
        |--------------------------------------------------------------------------
        */
        $categories = [
            'Hematology',
            'Biochemistry',
            'Immunology',
            'Microbiology',
        ];

        foreach ($categories as $cat) {
            LabTestCategory::firstOrCreate([
                'name' => $cat
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 2. LAB TESTS
        |--------------------------------------------------------------------------
        */
        $cbc = LabTest::firstOrCreate([
            'category_id' => LabTestCategory::where('name','Hematology')->first()->id,
            'name' => 'Complete Blood Count (CBC)',
            'method' => 'Automated Analyzer',
            'price' => 350,
        ]);

        $lft = LabTest::firstOrCreate([
            'category_id' => LabTestCategory::where('name','Biochemistry')->first()->id,
            'name' => 'Liver Function Test (LFT)',
            'method' => 'Spectrophotometry',
            'price' => 650,
        ]);

        /*
        |--------------------------------------------------------------------------
        | 3. TEST PARAMETERS
        |--------------------------------------------------------------------------
        */
        $cbcParams = [
            ['name'=>'Hemoglobin','unit'=>'g/dL','reference_range'=>'13-17'],
            ['name'=>'WBC','unit'=>'cells/mm³','reference_range'=>'4000-11000'],
            ['name'=>'Platelets','unit'=>'lakhs/mm³','reference_range'=>'1.5-4.5'],
        ];

        foreach ($cbcParams as $p) {
            LabTestParameter::firstOrCreate([
                'test_id' => $cbc->id,
                'name' => $p['name'],
                'unit' => $p['unit'],
                'reference_range' => $p['reference_range'],
            ]);
        }

        $lftParams = [
            ['name'=>'SGPT','unit'=>'U/L','reference_range'=>'7-56'],
            ['name'=>'SGOT','unit'=>'U/L','reference_range'=>'10-40'],
            ['name'=>'Bilirubin','unit'=>'mg/dL','reference_range'=>'0.2-1.2'],
        ];

        foreach ($lftParams as $p) {
            LabTestParameter::firstOrCreate([
                'test_id' => $lft->id,
                'name' => $p['name'],
                'unit' => $p['unit'],
                'reference_range' => $p['reference_range'],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 4. LAB TEST REQUEST
        |--------------------------------------------------------------------------
        */
        $patient = Patient::first(); // ensure patient exists
        $doctor  = User::role('Doctor')->first();

        if (!$patient || !$doctor) {
            $this->command->warn('Patient or Doctor not found. Lab request skipped.');
            return;
        }

        $request = LabTestRequest::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'status' => 'Sample Collected',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 5. REQUEST ITEMS
        |--------------------------------------------------------------------------
        */
        foreach ([$cbc, $lft] as $test) {
            LabTestRequestItem::create([
                'request_id' => $request->id,
                'test_id' => $test->id,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 6. TEST RESULTS
        |--------------------------------------------------------------------------
        */
        foreach ($cbc->parameters as $param) {
            LabTestResult::create([
                'request_id' => $request->id,
                'parameter_id' => $param->id,
                'value' => rand(10, 15),
            ]);
        }

        foreach ($lft->parameters as $param) {
            LabTestResult::create([
                'request_id' => $request->id,
                'parameter_id' => $param->id,
                'value' => rand(20, 60),
            ]);
        }

        // Mark completed
        $request->update(['status' => 'Completed']);
    }
}
