<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('opd_visits', function (Blueprint $table) {
            $table->id();
            $table->string('opd_no')->unique(); // OPD0001
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();

            $table->date('visit_date');

            // Symptoms & clinical notes
            $table->text('symptoms')->nullable();
            $table->text('diagnosis')->nullable();

            // Vitals
            $table->string('bp')->nullable();
            $table->string('temperature')->nullable();
            $table->string('pulse')->nullable();
            $table->string('weight')->nullable();

            $table->boolean('status')->default(1);

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
            $table->foreign('doctor_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('opd_visits');
    }
};
