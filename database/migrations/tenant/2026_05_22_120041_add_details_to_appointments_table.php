<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('visit_type')->nullable()->after('reason');
            $table->string('appointment_type')->nullable()->after('visit_type');
            $table->text('chief_complaint')->nullable()->after('appointment_type');
            $table->string('referral')->nullable()->after('chief_complaint');
            $table->string('priority')->nullable()->after('referral');
            $table->text('notes')->nullable()->after('priority');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'visit_type',
                'appointment_type',
                'chief_complaint',
                'referral',
                'priority',
                'notes',
            ]);
        });
    }
};
