<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('employee_designations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('employee_departments')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_designations');
    }
};
