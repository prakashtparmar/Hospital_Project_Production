<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {

            // Tenant ID must be string for stancl/tenancy
            $table->string('id')->primary();

            // Database name assigned to the tenant
            $table->string('tenancy_db_name')->nullable();

            // JSON data: hospital name, contact, address, config etc.
            $table->json('data')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
}
