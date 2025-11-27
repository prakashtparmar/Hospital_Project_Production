<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('medicine_stock_ledger', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('medicine_id');
            $table->integer('quantity');  // +IN or -OUT
            $table->string('type');       // PURCHASE, ISSUE_OPD, ISSUE_IPD, ADJUSTMENT
            $table->unsignedBigInteger('reference_id')->nullable(); // purchase_id or issue_id etc.

            $table->integer('running_stock'); // after this entry

            $table->timestamps();

            $table->foreign('medicine_id')->references('id')->on('medicines')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicine_stock_ledger');
    }
};
