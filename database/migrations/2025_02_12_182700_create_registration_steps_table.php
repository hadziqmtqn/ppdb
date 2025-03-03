<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('registration_steps', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->integer('serial_number');
            $table->string('title');
            $table->text('description');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_steps');
    }
};
