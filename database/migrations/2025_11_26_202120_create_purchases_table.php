<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
    $table->id();

    // Supplier
    $table->unsignedBigInteger('supplier_id')->nullable();

    // Invoice No
    $table->string('invoice_no')->nullable();

    // GRN No (Goods Receipt Note)
    $table->string('grn_no')->nullable();

    // Correct purchase date field
    $table->date('purchase_date')->nullable();

    // Totals
    $table->decimal('total_amount', 12, 2)->default(0);
    $table->decimal('tax_amount', 12, 2)->default(0);
    $table->decimal('grand_total', 12, 2)->default(0);

    /* ===========================================
       🔥 ADVANCED PURCHASE SYSTEM MISSING FIELDS
       (ADDED WITHOUT TOUCHING YOUR ORIGINAL FIELDS)
       =========================================== */

    // Supplier invoice date (also needed for GST audit)
    $table->date('invoice_date')->nullable();

    // Purchase type (cash / credit / card / NEFT)
    $table->string('payment_type')->default('credit');

    // Optional reference document from supplier
    $table->string('challan_no')->nullable();
    $table->date('challan_date')->nullable();

    // Discount on whole purchase (header-level)
    $table->decimal('discount_amount', 12, 2)->default(0);
    $table->decimal('discount_percent', 5, 2)->default(0);

    // Round off adjustment
    $table->decimal('round_off', 10, 2)->default(0);

    // Purchase Status
    // draft = editable, completed = stock updated, cancelled = reversed
    $table->enum('status', ['inapproval', 'approved','completed', 'cancelled'])->default('inapproval');

    // Transport details (common in hospital purchase GRNs)
    $table->string('transport_name')->nullable();
    $table->string('lr_no')->nullable();              // Lorry receipt no
    $table->date('lr_date')->nullable();

    // Additional note field
    $table->text('remarks')->nullable();


    $table->timestamps();
    $table->softDeletes();

    $table->foreign('supplier_id')
          ->references('id')
          ->on('suppliers')
          ->nullOnDelete();
});

    }

    public function down()
    {
        Schema::dropIfExists('purchases');
    }
};
