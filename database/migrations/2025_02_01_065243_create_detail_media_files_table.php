<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_media_files', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('media_file_id');
            $table->unsignedBigInteger('educational_institution_id');
            $table->unsignedBigInteger('registration_path_id')->nullable();
            $table->timestamps();

            $table->foreign('media_file_id')->references('id')->on('media_files')->cascadeOnDelete();
            $table->foreign('educational_institution_id')->references('id')->on('educational_institutions')->cascadeOnDelete();
            $table->foreign('registration_path_id')->references('id')->on('registration_paths')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_media_files');
    }
};
