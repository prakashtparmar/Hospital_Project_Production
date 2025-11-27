<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('unit_id');

            $table->string('sku')->nullable();
            $table->integer('reorder_level')->default(0);

            $table->integer('current_stock')->default(0);

            $table->decimal('mrp', 10,2)->default(0);
            $table->decimal('purchase_price', 10,2)->default(0);

            $table->boolean('status')->default(1);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('medicine_categories');
            $table->foreign('unit_id')->references('id')->on('medicine_units');
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicines');
    }
};
