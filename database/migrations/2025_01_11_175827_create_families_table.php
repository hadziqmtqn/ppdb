<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('national_identification_number');
            $table->string('family_card_number');
            $table->string('father_name')->nullable();
            $table->unsignedBigInteger('father_education_id')->nullable();
            $table->unsignedBigInteger('father_profession_id')->nullable();
            $table->unsignedBigInteger('father_income_id')->nullable();
            $table->string('mother_name');
            $table->unsignedBigInteger('mother_education_id')->nullable();
            $table->unsignedBigInteger('mother_profession_id')->nullable();
            $table->unsignedBigInteger('mother_income_id')->nullable();
            $table->boolean('have_a_guardian')->default(false);
            $table->string('guardian_name')->nullable();
            $table->unsignedBigInteger('guardian_education_id')->nullable();
            $table->unsignedBigInteger('guardian_profession_id')->nullable();
            $table->unsignedBigInteger('guardian_income_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('father_education_id')->references('id')->on('education')->restrictOnDelete();
            $table->foreign('father_profession_id')->references('id')->on('professions')->restrictOnDelete();
            $table->foreign('father_income_id')->references('id')->on('incomes')->restrictOnDelete();
            $table->foreign('mother_education_id')->references('id')->on('education')->restrictOnDelete();
            $table->foreign('mother_profession_id')->references('id')->on('professions')->restrictOnDelete();
            $table->foreign('mother_income_id')->references('id')->on('incomes')->restrictOnDelete();
            $table->foreign('guardian_education_id')->references('id')->on('education')->restrictOnDelete();
            $table->foreign('guardian_profession_id')->references('id')->on('professions')->restrictOnDelete();
            $table->foreign('guardian_income_id')->references('id')->on('incomes')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
