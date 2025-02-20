<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('registration_settings', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->unsignedBigInteger('educational_institution_id');
            $table->boolean('accepted_with_school_report')->default(false);
            $table->json('school_report_semester')->nullable();
            $table->timestamps();

            $table->foreign('educational_institution_id')->references('id')->on('educational_institutions')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_settings');
    }
};
