<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->integer('serial_number');
            $table->string('registration_number')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('school_year_id');
            $table->unsignedBigInteger('educational_institution_id');
            $table->unsignedBigInteger('registration_category_id');
            $table->unsignedBigInteger('registration_path_id')->nullable();
            $table->unsignedBigInteger('major_id')->nullable();
            $table->unsignedBigInteger('class_level_id');
            $table->string('whatsapp_number')->unique();
            $table->string('nisn')->nullable();
            $table->enum('registration_status', ['belum_diterima', 'diterima', 'ditolak'])->default('belum_diterima');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('school_year_id')->references('id')->on('school_years')->restrictOnDelete();
            $table->foreign('educational_institution_id')->references('id')->on('educational_institutions')->restrictOnDelete();
            $table->foreign('registration_category_id')->references('id')->on('registration_categories')->restrictOnDelete();
            $table->foreign('registration_path_id')->references('id')->on('registration_paths')->restrictOnDelete();
            $table->foreign('major_id')->references('id')->on('majors')->restrictOnDelete();
            $table->foreign('class_level_id')->references('id')->on('class_levels')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
