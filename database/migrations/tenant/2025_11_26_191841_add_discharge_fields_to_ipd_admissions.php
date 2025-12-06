<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('ipd_admissions', function (Blueprint $table) {
            $table->dateTime('discharge_date')->nullable();
            $table->text('discharge_summary')->nullable();
            $table->text('final_diagnosis')->nullable();
        });
    }

    public function down()
    {
        Schema::table('ipd_admissions', function (Blueprint $table) {
            $table->dropColumn(['discharge_date', 'discharge_summary', 'final_diagnosis']);
        });
    }
};
