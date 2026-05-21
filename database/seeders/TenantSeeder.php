<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\TenantDomain;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = [
            [
                'id'       => 'tenant1',
                'name'     => 'Main Hospital',
                'domain'   => 'hospital1.yourdomain.com',
                'database' => 'tenant1_db',
            ],
            [
                'id'       => 'tenant2',
                'name'     => 'Branch Hospital',
                'domain'   => 'hospital2.yourdomain.com',
                'database' => 'tenant2_db',
            ],
        ];

        foreach ($tenants as $data) {

            // Cannot be localhost-based
            if ($data['domain'] === 'localhost') {
                $this->command->warn("Skipped tenant on localhost");
                continue;
            }

            // Create tenant
            $tenant = Tenant::firstOrCreate(
                ['id' => $data['id']],
                [
                    'data' => ['name' => $data['name']],
                    'tenancy_db_name' => $data['database'],
                ]
            );

            // Assign tenant domain
            TenantDomain::firstOrCreate([
                'tenant_id' => $tenant->id,
                'domain'    => $data['domain'],
            ]);

            // Create tenant DB if missing
            DB::statement("CREATE DATABASE IF NOT EXISTS `{$data['database']}`");

            // Initialize tenant
            tenancy()->initialize($tenant);

            // Run tenant migrations
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path'     => 'database/migrations/tenant',
                '--force'    => true,
            ]);

            tenancy()->end();
        }
    }
}
