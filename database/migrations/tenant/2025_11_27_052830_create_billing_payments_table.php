<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('billing_payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('invoice_id');

            $table->decimal('amount', 12,2);
            $table->string('mode'); // Cash, Card, UPI, Online
            $table->string('note')->nullable();

            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('billing_invoices')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billing_payments');
    }
};
