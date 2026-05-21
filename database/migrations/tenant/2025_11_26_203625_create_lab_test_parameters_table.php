<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('lab_test_parameters', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('test_id');

            $table->string('name');
            $table->string('unit')->nullable();
            $table->string('reference_range')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('test_id')->references('id')->on('lab_tests')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lab_test_parameters');
    }
};
