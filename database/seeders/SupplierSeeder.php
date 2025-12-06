<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $suppliers = [
            ['name' => 'Apollo Pharma Distributors', 'phone' => '9876543210', 'address' => 'Mumbai'],
            ['name' => 'Sun Medical Agency', 'phone' => '9822334455', 'address' => 'Pune'],
            ['name' => 'Medilife Wholesale', 'phone' => '9765432190', 'address' => 'Delhi'],
        ];

        foreach ($suppliers as $s) {
            Supplier::updateOrCreate(
                ['name' => $s['name']],
                [
                    'contact_person' => 'Manager',
                    'phone' => $s['phone'],
                    'email' => strtolower(str_replace(' ', '_', $s['name'])) . '@mail.com',
                    'address' => $s['address'],
                    'status' => 1
                ]
            );
        }
    }
}
