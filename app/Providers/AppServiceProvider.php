<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Spatie\Activitylog\Models\Activity;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.navbar_notifications', function ($view) {
            $logs = collect();

            if (auth()->check() && auth()->user()->can('auditlogs.view')) {
                try {
                    $logs = Activity::with('causer')
                        ->latest('id')
                        ->take(8)
                        ->get();
                } catch (Throwable $e) {
                    $logs = collect();
                }
            }

            $view->with([
                'navbarActivityLogs' => $logs,
                'navbarActivityLogCount' => $logs->count(),
            ]);
        });
    }
}
