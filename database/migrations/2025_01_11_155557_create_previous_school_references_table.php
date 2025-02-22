<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('previous_school_references', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->unsignedBigInteger('educational_group_id');
            $table->string('npsn')->nullable();
            $table->string('name');
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('village')->nullable();
            $table->string('street')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('educational_group_id')->references('id')->on('educational_groups')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('previous_school_references');
    }
};
