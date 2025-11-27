<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Stancl\Tenancy\Database\Models\Tenant;
use Illuminate\Support\Facades\Artisan;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = [
            [
                'id' => 'tenant1',
                'name' => 'Main Hospital Tenant',
                'domain' => 'main.localhost',
                'database' => 'tenant1_db',
            ],
            [
                'id' => 'tenant2',
                'name' => 'Branch 1 Hospital Tenant',
                'domain' => 'branch1.localhost',
                'database' => 'tenant2_db',
            ],
        ];

        foreach ($tenants as $data) {
            // Create tenant if not exists
            $tenant = Tenant::firstOrCreate(
                ['id' => $data['id']],
                [
                    'name' => $data['name'],
                    'data' => [
                        'database' => $data['database'],
                        'domain' => $data['domain'],
                    ],
                ]
            );

            $this->command->info("Tenant '{$data['name']}' created with database {$data['database']}");

            // Initialize tenant connection
            tenancy()->initialize($tenant);

            // Run all tenant migrations
            Artisan::call('tenants:migrate', [
                '--tenants' => [$tenant->id],
                '--force' => true,
            ]);

            $this->command->info("Migrations run for tenant: {$tenant->id}");

            // End tenancy
            tenancy()->end();
        }
    }
}
