<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ipd_admissions', function (Blueprint $table) {
            $table->id();
            $table->string('ipd_no')->unique(); // IPD0001
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();

            $table->unsignedBigInteger('ward_id')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('bed_id')->nullable();

            $table->dateTime('admission_date');
            $table->text('admission_reason')->nullable();
            $table->text('initial_diagnosis')->nullable();

            $table->boolean('status')->default(1); // 1-Admitted, 0-Discharged

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
            $table->foreign('doctor_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();

            $table->foreign('ward_id')->references('id')->on('wards')->nullOnDelete();
            $table->foreign('room_id')->references('id')->on('rooms')->nullOnDelete();
            $table->foreign('bed_id')->references('id')->on('beds')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ipd_admissions');
    }
};
