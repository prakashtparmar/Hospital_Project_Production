<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            // Core
            $table->string('patient_id')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();

            // Personal
            $table->date('date_of_birth')->nullable();
            $table->string('gender');
            $table->integer('age')->nullable();

            // Contact
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();

            // Emergency
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relation')->nullable();

            // Extra
            $table->string('family_details')->nullable();
            $table->text('past_history')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('qr_code')->nullable();

            // Relations
            $table->unsignedBigInteger('department_id')->nullable();
            $table->boolean('status')->default(1);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
        });

    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
};