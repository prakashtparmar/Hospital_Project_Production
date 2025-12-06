<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('radiology_request_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('test_id');
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('radiology_requests')->cascadeOnDelete();
            $table->foreign('test_id')->references('id')->on('radiology_tests')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('radiology_request_items');
    }
};
