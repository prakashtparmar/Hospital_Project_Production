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
        Schema::create('prescription_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('prescription_id')->constrained()->cascadeOnDelete();

    $table->string('drug_name');
    $table->string('strength')->nullable();      // 500 mg, 15 ml etc
    $table->string('dose')->nullable();          // 1-0-1
    $table->string('route')->nullable();         // Oral, IV etc
    $table->string('frequency')->nullable();     // OD, BD, TDS
    $table->string('duration')->nullable();      // 5 days
    $table->text('instructions')->nullable();    // after food, etc

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_items');
    }
};
