<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Artisan;
use Stancl\Tenancy\Contracts\Tenant;

class MigrateTenantJob
{
    use Queueable;

    /** @var Tenant */
    public Tenant $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle()
    {
        // Initialize tenancy
        tenancy()->initialize($this->tenant);

        // Run tenant migrations
        Artisan::call('tenants:migrate', [
            '--tenants' => [$this->tenant->id],
            '--force' => true,
        ]);

        tenancy()->end();
    }
}
