<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('educational_institutions', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->unsignedBigInteger('educational_level_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('village')->nullable();
            $table->string('street')->nullable();
            $table->integer('postal_code')->nullable();
            $table->text('profile')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('educational_level_id')->references('id')->on('educational_levels')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educational_institutions');
    }
};
