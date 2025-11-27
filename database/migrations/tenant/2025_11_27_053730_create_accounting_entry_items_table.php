<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('accounting_entry_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('entry_id');
            $table->unsignedBigInteger('account_id');

            $table->decimal('debit', 12,2)->default(0);
            $table->decimal('credit', 12,2)->default(0);

            $table->timestamps();

            $table->foreign('entry_id')->references('id')->on('accounting_entries')->cascadeOnDelete();
            $table->foreign('account_id')->references('id')->on('accounts')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('accounting_entry_items');
    }
};
