<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('issue_medicine_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('issue_id');
            $table->unsignedBigInteger('medicine_id');

            $table->integer('quantity');
            $table->decimal('rate', 10,2);
            $table->decimal('amount', 10,2);

            $table->timestamps();

            $table->foreign('issue_id')->references('id')->on('issue_medicines')->cascadeOnDelete();
            $table->foreign('medicine_id')->references('id')->on('medicines')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('issue_medicine_items');
    }
};
