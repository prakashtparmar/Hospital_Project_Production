<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
    $table->id();

    $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
    $table->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
    $table->foreignId('appointment_id')->nullable()->constrained()->nullOnDelete();

    $table->enum('status', ['in_progress', 'completed', 'cancelled'])->default('in_progress');

    // Quick summary fields
    $table->text('chief_complaint')->nullable();
    $table->text('history')->nullable();
    $table->text('examination')->nullable();
    $table->text('provisional_diagnosis')->nullable();
    $table->text('final_diagnosis')->nullable();
    $table->text('plan')->nullable();

    // Vitals (can also be separate table if you prefer)
    $table->string('bp')->nullable();      // 120/80
    $table->integer('pulse')->nullable();  // bpm
    $table->decimal('temperature', 5, 2)->nullable();
    $table->integer('resp_rate')->nullable();
    $table->integer('spo2')->nullable();
    $table->decimal('weight', 8, 2)->nullable();
    $table->decimal('height', 8, 2)->nullable();

    $table->timestamp('started_at')->nullable();
    $table->timestamp('ended_at')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
