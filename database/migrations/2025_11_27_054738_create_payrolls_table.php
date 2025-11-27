<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employee_id');
            $table->string('month');
            $table->string('year');

            $table->decimal('basic', 12,2);
            $table->decimal('hra', 12,2);
            $table->decimal('da', 12,2);
            $table->decimal('allowance', 12,2);
            $table->decimal('pf', 12,2);
            $table->decimal('tds', 12,2);
            $table->decimal('leave_deduction', 12,2);
            $table->decimal('net_salary', 12,2);

            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
};
