<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('educational_groups', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->string('code')->unique();
            $table->string('name');
            $table->unsignedBigInteger('next_educational_level_id');
            $table->timestamps();

            $table->foreign('next_educational_level_id')->references('id')->on('educational_levels')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educational_groups');
    }
};
