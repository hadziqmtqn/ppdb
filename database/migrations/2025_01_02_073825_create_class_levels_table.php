<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('class_levels', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug');
            $table->unsignedBigInteger('educational_institution_id');
            $table->unsignedBigInteger('registration_category_id');
            $table->string('code');
            $table->string('name');
            $table->timestamps();

            $table->foreign('educational_institution_id')->references('id')->on('educational_institutions')->restrictOnDelete();
            $table->foreign('registration_category_id')->references('id')->on('registration_categories')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_levels');
    }
};
