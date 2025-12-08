<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Roles
        foreach ([
            'master-admin','Admin','Doctor','Lab Technician','Radiology Technician'
        ] as $role) {
            Role::firstOrCreate(['name'=>$role,'guard_name'=>'web']);
        }

        // MASTER ADMIN
        User::firstOrCreate(
            ['email'=>'admin@example.com'],
            ['name'=>'Master Admin','password'=>Hash::make('password')]
        )->assignRole('master-admin');

        // DOCTOR
        User::firstOrCreate(
            ['email'=>'doctor@example.com'],
            ['name'=>'Dr. Tony Stark','password'=>Hash::make('password')]
        )->assignRole('Doctor');

        // LAB TECH
        User::firstOrCreate(
            ['email'=>'lab@example.com'],
            ['name'=>'Lab Technician','password'=>Hash::make('password')]
        )->assignRole('Lab Technician');

        // RADIOLOGY TECH
        User::firstOrCreate(
            ['email'=>'radio@example.com'],
            ['name'=>'Radiology Technician','password'=>Hash::make('password')]
        )->assignRole('Radiology Technician');
    }
}
