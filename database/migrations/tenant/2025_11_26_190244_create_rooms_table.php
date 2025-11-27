<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ward_id');
            $table->string('room_no');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ward_id')->references('id')->on('wards')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};
