<?php

declare(strict_types=1);

use Stancl\Tenancy\Bootstrappers;
use App\Models\Tenant;
use App\Models\TenantDomain;
use Stancl\Tenancy\UUIDGenerator;

return [

    // ------------------------------
    // Tenant & Domain Models
    // ------------------------------
    'tenant_model' => Tenant::class,
    'domain_model' => TenantDomain::class,

    'id_generator' => UUIDGenerator::class,

    // ------------------------------
    // Central Domains (Panel / Admin)
    // ------------------------------
    // 'central_domains' => [
    //     env('CENTRAL_DOMAIN', 'localhost'),
    // ],

    'central_domains' => [
        'localhost',
        '127.0.0.1',
    ],


    // ------------------------------
    // Bootstrappers
    // ------------------------------
    'bootstrappers' => [
        Bootstrappers\DatabaseTenancyBootstrapper::class,
        Bootstrappers\CacheTenancyBootstrapper::class,
        Bootstrappers\FilesystemTenancyBootstrapper::class,
        Bootstrappers\QueueTenancyBootstrapper::class,
    ],

    // ------------------------------
    // Database Configuration
    // ------------------------------
    'database' => [
        'central_connection' => env('DB_CONNECTION', 'mysql'),
        'tenant_connection' => 'tenant',

        'prefix' => 'tenant_',
        'suffix' => '',

        'managers' => [
            'mysql' => Stancl\Tenancy\TenantDatabaseManagers\MySQLDatabaseManager::class,
        ],
    ],

    // ------------------------------
    // Cache
    // ------------------------------
    'cache' => [
        'tag_base' => 'tenant',
    ],

    // ------------------------------
    // Filesystem
    // ------------------------------
    'filesystem' => [
        'suffix_base' => 'tenant',
        'disks' => ['local', 'public'],
        'suffix_storage_path' => true,
        'asset_helper_tenancy' => true,
    ],

    // ------------------------------
    // Redis
    // ------------------------------
    'redis' => [
        'prefix_base' => 'tenant',
        'prefixed_connections' => [],
    ],

    // ------------------------------
    // Features (Optional)
    // ------------------------------
    'features' => [],

    // ------------------------------
    // Routes
    // ------------------------------
    'routes' => false,

    // ------------------------------
    // Migration Parameters
    // ------------------------------
    'migration_parameters' => [
        '--force' => true,
        '--path' => [database_path('migrations/tenant')],
        '--realpath' => true,
    ],

    'seeder_parameters' => [
        '--class' => 'DatabaseSeeder',
    ],
];
