<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // If table doesn't exist, skip migration safely
        if (!Schema::hasTable('medicine_stock_ledger')) {
            return;
        }

        Schema::table('medicine_stock_ledger', function (Blueprint $table) {

            // Add batch_no if missing
            if (!Schema::hasColumn('medicine_stock_ledger', 'batch_no')) {
                $table->string('batch_no')->nullable()->after('running_stock');
            }

            // Add expiry_date if missing
            if (!Schema::hasColumn('medicine_stock_ledger', 'expiry_date')) {
                $table->date('expiry_date')->nullable()->after('batch_no');
            }

            // Add remarks if missing
            if (!Schema::hasColumn('medicine_stock_ledger', 'remarks')) {
                $table->string('remarks')->nullable()->after('expiry_date');
            }
        });
    }

    public function down()
    {
        // Prevent failure if table is missing
        if (!Schema::hasTable('medicine_stock_ledger')) {
            return;
        }

        Schema::table('medicine_stock_ledger', function (Blueprint $table) {

            if (Schema::hasColumn('medicine_stock_ledger', 'remarks')) {
                $table->dropColumn('remarks');
            }

            if (Schema::hasColumn('medicine_stock_ledger', 'expiry_date')) {
                $table->dropColumn('expiry_date');
            }

            if (Schema::hasColumn('medicine_stock_ledger', 'batch_no')) {
                $table->dropColumn('batch_no');
            }
        });
    }
};
