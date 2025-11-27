<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('department_id')->nullable();

            $table->string('day'); // Monday, Tuesday...
            $table->time('start_time');
            $table->time('end_time');

            $table->integer('slot_duration')->default(15); // 15 minutes per patient

            $table->boolean('status')->default(1);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('doctor_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
