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

            // Tenant ID (string, required by stancl/tenancy)
            $table->string('id')->primary();

            // (Optional) dedicated database name for this tenant
            $table->string('tenancy_db_name')->nullable();

            // JSON column that stores hospital name, contact, address, etc.
            $table->json('data')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
}
