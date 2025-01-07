<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('message_receivers', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('message_template_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('message_template_id')->references('id')->on('message_templates')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_receivers');
    }
};
