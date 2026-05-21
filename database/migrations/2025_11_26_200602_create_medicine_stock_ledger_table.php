<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('medicine_stock_ledger', function (Blueprint $table) {
            $table->id();

            // Medicine reference
            $table->unsignedBigInteger('medicine_id');

            // Batch reference (NO foreign key to avoid FK errors)
            $table->unsignedBigInteger('batch_id')->nullable();

            // Stock movement
            $table->integer('quantity');  // +IN or -OUT
            $table->string('type');       // PURCHASE, ISSUE, ADJUSTMENT, RETURN, etc.
            $table->unsignedBigInteger('reference_id')->nullable(); // purchase_id OR issue_id

            // running stock after this entry
            $table->integer('running_stock');

            $table->timestamps();

            // Only one safe foreign key
            $table->foreign('medicine_id')
                  ->references('id')->on('medicines')
                  ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicine_stock_ledger');
    }
};
