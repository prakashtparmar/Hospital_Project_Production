<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('accounting_entries', function (Blueprint $table) {
            $table->id();

            $table->date('entry_date');
            $table->string('voucher_no')->unique();
            $table->string('type'); // Receipt, Payment, Journal

            $table->string('reference_type')->nullable(); // Billing, Purchase, Refund
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('accounting_entries');
    }
};
