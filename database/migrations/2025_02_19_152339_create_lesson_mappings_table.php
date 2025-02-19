<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lesson_mappings', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->unsignedBigInteger('lesson_id');
            $table->unsignedBigInteger('educational_institution_id');
            $table->json('previous_educational_group');
            $table->timestamps();

            $table->foreign('lesson_id')->references('id')->on('lessons')->restrictOnDelete();
            $table->foreign('educational_institution_id')->references('id')->on('educational_institutions')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_mappings');
    }
};
