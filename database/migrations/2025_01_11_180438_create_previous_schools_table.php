<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('previous_schools', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('previous_school_reference_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('previous_school_reference_id')->references('id')->on('previous_school_references')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('previous_schools');
    }
};
