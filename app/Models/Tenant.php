<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDomains, HasDatabase;

    // protected $fillable = [
    //     'id',
    //     'data',
    // ];

    protected $fillable = ['id', 'data','tenancy_db_name'];

    protected $casts = [
        'data' => 'array',
    ];

    public function getDatabaseName(): string
    {
        // return 'tenant_' . $this->id;
        return $this->tenancy_db_name;
    }
}
