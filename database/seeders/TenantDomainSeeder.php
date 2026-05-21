<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantDomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert tenant_3 and domain record
        DB::table('tenants')->insert([
            'id' => 'tenant_3',
            'data' => '{}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('domains')->insert([
            'domain' => 'branch1.localhost',
            'tenant_id' => 'tenant_3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert tenant_2 and domain record
        DB::table('tenants')->insert([
            'id' => 'tenant_2',
            'data' => '{}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('domains')->insert([
            'domain' => 'main.localhost',
            'tenant_id' => 'tenant_2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert tenant_1 and domain record
        DB::table('tenants')->insert([
            'id' => 'tenant_1',
            'data' => '{}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('domains')->insert([
            'domain' => 'localhost',
            'tenant_id' => 'tenant_1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
