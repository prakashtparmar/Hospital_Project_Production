<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('leave_applications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('leave_type_id');

            $table->date('from_date');
            $table->date('to_date');

            $table->text('reason')->nullable();

            $table->enum('status',['Pending','Approved','Rejected'])->default('Pending');

            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnDelete();
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leave_applications');
    }
};
