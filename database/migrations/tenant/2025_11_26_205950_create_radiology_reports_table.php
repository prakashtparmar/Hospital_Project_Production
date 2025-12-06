<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('radiology_reports', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('request_id');

            $table->text('report')->nullable();
            $table->text('impression')->nullable();

            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('radiology_requests')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('radiology_reports');
    }
};
