<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_school_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_report_id');
            $table->unsignedBigInteger('lesson_id');
            $table->float('score');
            $table->timestamps();

            $table->foreign('school_report_id')->references('id')->on('school_reports')->cascadeOnDelete();
            $table->foreign('lesson_id')->references('id')->on('lessons')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_school_reports');
    }
};
