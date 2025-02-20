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
            $table->string('school_name');
            $table->unsignedBigInteger('educational_group_id');
            $table->enum('status', ['Negeri', 'Swasta']);
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('village')->nullable();
            $table->string('street')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('educational_group_id')->references('id')->on('educational_groups')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('previous_schools');
    }
};
