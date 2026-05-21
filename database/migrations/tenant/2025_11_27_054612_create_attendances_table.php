<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employee_id');

            $table->date('date');
            $table->enum('status',['Present','Absent','Leave'])->default('Present');

            $table->timestamps();

            $table->unique(['employee_id','date']);

            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};
