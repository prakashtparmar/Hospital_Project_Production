<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('medicine_units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Tablet, Strip, Bottle

            // Added ONLY required fields — no other logic changed
            $table->string('slug')->unique()->nullable();
            $table->string('type')->nullable();
            $table->string('description')->nullable();

            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicine_units');
    }
};
