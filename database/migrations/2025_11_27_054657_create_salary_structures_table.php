<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('salary_structures', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employee_id');

            $table->decimal('hra_percent', 5,2)->default(0);
            $table->decimal('da_percent', 5,2)->default(0);
            $table->decimal('other_allowance', 12,2)->default(0);

            $table->decimal('pf_percent', 5,2)->default(0);
            $table->decimal('tds_percent', 5,2)->default(0);

            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salary_structures');
    }
};
