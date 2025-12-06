<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('lab_test_results', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('parameter_id');

            $table->string('value')->nullable();

            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('lab_test_requests')->cascadeOnDelete();
            $table->foreign('parameter_id')->references('id')->on('lab_test_parameters')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lab_test_results');
    }
};
