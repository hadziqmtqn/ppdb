<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('message_templates', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->string('title');
            $table->unsignedBigInteger('educational_institution_id');
            $table->string('category');
            $table->text('message');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('educational_institution_id')->references('id')->on('educational_institutions')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_templates');
    }
};
