<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Models\DoctorProfile;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use Carbon\Carbon;

class DummyScheduleSeeder extends Seeder
{
    public function run()
    {
        // 1. Ensure Doctor Role Exists
        $doctorRole = Role::firstOrCreate(['name' => 'Doctor']);

        // 2. Create Departments
$departments = [
    // Clinical Specialties
    "Cardiology",
    "Orthopedics",
    "Gynecology / Obstetrics (OB/GYN)",
    "Dermatology",
    "General Medicine",
    "General Surgery",
    "Pediatrics",
    "Oncology",
    "Neurology",
    "ENT (Otorhinolaryngology)",
    "Ophthalmology",
    "Urology",
    "Gastroenterology",
    "Nephrology",
    "Pulmonology",
    "Psychiatry",
    "Anesthesiology",
    "Infectious Diseases",
    "Endocrinology",
    "Rheumatology",
    
    // Care Units & Services
    "OPD (Outpatient Department)",
    "IPD (Inpatient Department) / Wards",
    "Emergency / Casualty Department (ED/ER)",
    "ICU (Intensive Care Unit)",
    "NICU / PICU",
    "Operation Theatre (OT) / Surgical Suite",
    "PACU (Post-Anesthesia Care Unit) / Recovery",
    "Rehabilitation / Physical Therapy",
    
    // Diagnostic & Support Services
    "Radiology / Imaging",
    "Pathology / Laboratory",
    "Pharmacy",
    "Blood Bank / Transfusion Services",
    "Dietetics & Nutrition",
    "Central Sterilization Supply Department (CSSD)",
    
    // Administrative & General Support
    "Admin / Management",
    "Human Resources (HR)",
    "Finance & Billing / Accounts",
    "Medical Records / HIM",
    "Inventory / Store (Materials Management)",
    "IT (Information Technology)",
    "Maintenance / Engineering",
    "Housekeeping / Environmental Services",
    "Security",
    "Ambulance Services / Patient Transport",
    "Canteen / Food Services"
];

        foreach ($departments as $dep) {
            Department::firstOrCreate(
                ['name' => $dep],
                ['status' => 1]
            );
        }

        $deptAll = Department::all();

        // 3. Create Dummy Doctors (Users)
        $doctorList = [];

        for ($i = 1; $i <= 5; $i++) {

            $user = User::firstOrCreate(
                ['email' => "doctor$i@example.com"],
                [
                    'name' => "Doctor $i",
                    'password' => Hash::make('password')
                ]
            );

            $user->assignRole($doctorRole);
            $doctorList[] = $user;
        }

        // 4. Create Doctor Profiles
        foreach ($doctorList as $doc) {

            DoctorProfile::firstOrCreate(
                ['user_id' => $doc->id],
                [
                    'department_id'  => $deptAll->random()->id,
                    'specialization' => 'General Specialist',
                    'qualification'  => 'MBBS, MD',
                    'registration_no'=> 'REG' . rand(1000,9999),
                    'consultation_fee' => rand(300,700),
                    'biography' => 'Experienced doctor with excellent patient care skills.'
                ]
            );
        }

        // 5. Create Doctor Schedules
        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

        foreach ($doctorList as $doc) {
            foreach ($days as $day) {

                DoctorSchedule::firstOrCreate(
                    [
                        'doctor_id' => $doc->id,
                        'day' => $day,
                    ],
                    [
                        'department_id' => DoctorProfile::where('user_id', $doc->id)->value('department_id'),
                        'start_time'    => '10:00',
                        'end_time'      => '14:00',
                        'slot_duration' => 15,
                        'status'        => 1
                    ]
                );
            }
        }

        // 6. Create Sample Patients (NO full_name column)
        for ($i = 1; $i <= 10; $i++) {
            Patient::firstOrCreate(
                ['patient_id' => "P00$i"],
                [
                    'first_name' => "Patient$i",
                    'last_name'  => "Demo",
                    'gender'     => 'Male',
                    'age'        => rand(20,60),
                    'phone'      => '98765' . rand(10000,99999),
                    'email'      => "patient$i@example.com",
                    'address'    => "Sample address $i",
                    'department_id' => $deptAll->random()->id,
                    'status'     => 1
                ]
            );
        }

        echo "Dummy data created successfully.\n";
    }
}
