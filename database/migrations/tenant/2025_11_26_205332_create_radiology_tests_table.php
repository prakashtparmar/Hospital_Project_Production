<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('radiology_tests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_id');

            $table->string('name');
            $table->string('modality'); // X-RAY, CT, MRI, USG, ECG, ECHO
            $table->decimal('price', 10,2)->default(0);
            $table->boolean('status')->default(1);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('radiology_categories');
        });
    }

    public function down()
    {
        Schema::dropIfExists('radiology_tests');
    }
};
