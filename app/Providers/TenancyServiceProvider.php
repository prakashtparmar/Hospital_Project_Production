<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Events;
use Stancl\Tenancy\Jobs;
use Stancl\JobPipeline\JobPipeline;
use Stancl\Tenancy\Middleware;

class TenancyServiceProvider extends ServiceProvider
{
    public function register()
    {
        // ❌ REMOVE THIS:
        // $this->loadMigrationsFrom(database_path('migrations/tenant'));
        // Stancl handles tenant migration loading internally.
    }

    public function boot()
    {
        $this->registerEvents();
        $this->mapTenantRoutes();
        $this->setMiddlewarePriority();
    }

    protected function registerEvents()
    {
        // Stancl’s default job pipeline
        Event::listen(Events\TenantCreated::class, JobPipeline::make([
            Jobs\CreateDatabase::class,
            Jobs\MigrateDatabase::class,
        ])->send(fn($event) => $event->tenant)->toListener());

        Event::listen(Events\TenantDeleted::class, JobPipeline::make([
            Jobs\DeleteDatabase::class,
        ])->send(fn($event) => $event->tenant)->toListener());
    }

    protected function mapTenantRoutes()
    {
        Route::middleware([
            'web',
            Middleware\InitializeTenancyByDomain::class,
            Middleware\PreventAccessFromCentralDomains::class,
            
        ])->group(base_path('routes/tenant.php'));
    }

    protected function setMiddlewarePriority()
    {
        $priority = [
            Middleware\PreventAccessFromCentralDomains::class,
            Middleware\InitializeTenancyByDomain::class,
        ];

        foreach (array_reverse($priority) as $m) {
            $this->app->make(\Illuminate\Contracts\Http\Kernel::class)
                ->prependToMiddlewarePriority($m);
        }
    }
}
