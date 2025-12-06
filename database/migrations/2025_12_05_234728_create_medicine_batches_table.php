<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medicine_batches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medicine_id')->index();

            $table->string('batch_no')->index();
            $table->date('expiry_date')->nullable();

            $table->decimal('purchase_rate', 12, 2)->nullable();
            $table->decimal('sale_rate', 12, 2)->nullable();
            $table->decimal('mrp', 12, 2)->nullable();

            $table->integer('current_stock')->default(0);

            $table->timestamps();

            $table->foreign('medicine_id')->references('id')->on('medicines')->cascadeOnDelete();
            $table->unique(['medicine_id', 'batch_no']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicine_batches');
    }
};
