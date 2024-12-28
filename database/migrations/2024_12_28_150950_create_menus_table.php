<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->integer('serial_number');
            $table->string('name');
            $table->enum('type', ['main_menu', 'sub_menu'])->default('main_menu');
            $table->string('main_menu')->nullable();
            $table->json('visibility');
            $table->string('url');
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
