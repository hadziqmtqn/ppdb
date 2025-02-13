<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->unsignedBigInteger('faq_category_id');
            $table->unsignedBigInteger('educational_institution_id')->nullable();
            $table->string('title');
            $table->longText('description');
            $table->timestamps();

            $table->foreign('faq_category_id')->references('id')->on('faq_categories')->cascadeOnDelete();
            $table->foreign('educational_institution_id')->references('id')->on('educational_institutions')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
