<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDomains;  // This will automatically handle domains relationship if 'domains' is the correct table.
    use HasDatabase;

    /**
     * The connection name for the model.
     * This model uses the central database connection.
     */
    protected $connection = 'mysql';  // Use the central database connection

    protected $fillable = ['id', 'data', 'tenancy_db_name'];  // Mass-assignable attributes

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Get the database name for the tenant.
     *
     * @return string
     */
    public function getDatabaseName(): string
    {
        return empty($this->tenancy_db_name) ? 'default_tenant_db' : $this->tenancy_db_name;
    }

    /**
     * Define the relationship with the TenantDomain (domains) model.
     * This will reference the TenantDomain model instead of the Domain model.
     */
    public function tenantDomains()
    {
        return $this->hasMany(TenantDomain::class, 'tenant_id', 'id');  // The 'tenant_id' references the 'id' of Tenant
    }
}
