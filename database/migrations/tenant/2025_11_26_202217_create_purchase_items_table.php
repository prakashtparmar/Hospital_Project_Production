<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('medicine_id');

            $table->integer('quantity');
            $table->decimal('rate', 10,2)->default(0);
            $table->decimal('amount', 10,2)->default(0);

            $table->timestamps();

            $table->foreign('purchase_id')->references('id')->on('purchases')->cascadeOnDelete();
            $table->foreign('medicine_id')->references('id')->on('medicines')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_items');
    }
};
