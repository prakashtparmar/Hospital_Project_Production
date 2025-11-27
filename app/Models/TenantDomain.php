<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantDomain extends Model
{
    // Explicitly set the correct table name
    protected $table = 'domains';  // Ensure this matches the table name in your database

    // Define the attributes that are mass-assignable
    protected $fillable = ['domain', 'tenant_id'];

    /**
     * Define the relationship back to the Tenant model.
     * The foreign key is 'tenant_id' in this case.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');  // 'tenant_id' references the 'id' in Tenant
    }
}
