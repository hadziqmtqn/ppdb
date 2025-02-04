<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug');
            $table->unsignedBigInteger('educational_institution_id');
            $table->enum('payment_method', ['MANUAL_PAYMENT', 'PAYMENT_GATEWAY'])
                ->default('PAYMENT_GATEWAY');
            $table->timestamps();

            $table->foreign('educational_institution_id')
                ->references('id')
                ->on('educational_institutions')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};
