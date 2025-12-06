<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();

            $table->date('joining_date')->nullable();
            $table->date('leaving_date')->nullable();

            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();

            $table->decimal('basic_salary', 12,2)->default(0);

            $table->boolean('status')->default(1);

            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('employee_departments')->nullOnDelete();
            $table->foreign('designation_id')->references('id')->on('employee_designations')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
