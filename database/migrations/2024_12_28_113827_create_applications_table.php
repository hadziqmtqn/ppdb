<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug');
            $table->string('name');
            $table->string('foundation');
            $table->string('description')->nullable();
            $table->string('website')->nullable();
            $table->string('main_website')->nullable();
            $table->boolean('register_verification')->default(false);
            $table->enum('notification_method', ['email', 'whatsapp']);
            $table->string('whatsapp_number');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
