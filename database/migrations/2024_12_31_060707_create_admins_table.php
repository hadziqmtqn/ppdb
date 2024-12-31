<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('educational_institution_id')->nullable();
            $table->string('whatsapp_number');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('educational_institution_id')->references('id')->on('educational_institutions')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
