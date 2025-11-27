<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('billing_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('invoice_id');

            $table->string('item_name');
            $table->integer('qty')->default(1);
            $table->decimal('rate', 10,2)->default(0);
            $table->decimal('amount', 10,2)->default(0);

            $table->string('source_type')->nullable();  // 'OPD','IPD','Pharmacy','Lab','Radiology'
            $table->unsignedBigInteger('source_id')->nullable(); // reference to module

            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('billing_invoices')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billing_items');
    }
};
