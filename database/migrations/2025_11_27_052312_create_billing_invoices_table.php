<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('billing_invoices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('opd_id')->nullable();
            $table->unsignedBigInteger('ipd_id')->nullable();

            $table->string('invoice_no')->unique();

            $table->decimal('total', 12,2)->default(0);
            $table->decimal('discount', 12,2)->default(0);
            $table->decimal('net_amount', 12,2)->default(0);
            $table->decimal('paid_amount', 12,2)->default(0);
            $table->decimal('due_amount', 12,2)->default(0);

            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billing_invoices');
    }
};
