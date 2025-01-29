<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('personal_data', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->integer('child_to');
            $table->integer('number_of_brothers');
            $table->string('family_relationship');
            $table->enum('religion', ['Islam', 'Protestan', 'Katolik', 'Buddha', 'Hindu', 'Khonghucu']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_data');
    }
};
