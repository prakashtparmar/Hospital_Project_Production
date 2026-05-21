<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('purchase_items', function (Blueprint $table) {
    $table->id();

    // Foreign Keys
    $table->unsignedBigInteger('purchase_id');
    $table->unsignedBigInteger('medicine_id');

    // Item details
    $table->integer('quantity');
    $table->decimal('rate', 10, 2)->default(0);
    $table->decimal('amount', 10, 2)->default(0);

    // Added fields (controller/form requirement)
    $table->integer('tax_percent')->default(0);      // GST %
    $table->string('batch_no')->nullable();          // Batch Number
    $table->date('expiry_date')->nullable();         // Expiry Date

    /* ================================
       🔥 ADVANCED SYSTEM MISSING FIELDS
       (ADDED WITHOUT MODIFYING EXISTING ONES)
       ================================ */

    // Free Items (commonly supplied by vendors)
    $table->integer('free_qty')->default(0);

    // MRP & Selling price for pharmacy billing
    $table->decimal('mrp', 10, 2)->default(0);
    $table->decimal('sale_rate', 10, 2)->default(0);

    // Manufacture Date (many hospitals require batch mfg date)
    $table->date('manufacture_date')->nullable();

    // Discount (line-level)
    $table->decimal('discount_percent', 10, 2)->default(0);
    $table->decimal('discount_amount', 10, 2)->default(0);

    // Tax calculations
    $table->decimal('taxable_amount', 10, 2)->default(0);
    $table->decimal('tax_amount', 10, 2)->default(0);

    // Final total after tax + discount
    $table->decimal('total_amount', 10, 2)->default(0);

    $table->timestamps();

    // Foreign Relations
    $table->foreign('purchase_id')
          ->references('id')->on('purchases')
          ->cascadeOnDelete();

    $table->foreign('medicine_id')
          ->references('id')->on('medicines')
          ->cascadeOnDelete();
});

    }

    public function down()
    {
        Schema::dropIfExists('purchase_items');
    }
};
