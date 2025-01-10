<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('account_verifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('new_email');
            $table->string('token');
            $table->dateTime('expired_at');
            $table->enum('status', ['pending', 'verified'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_verifications');
    }
};
