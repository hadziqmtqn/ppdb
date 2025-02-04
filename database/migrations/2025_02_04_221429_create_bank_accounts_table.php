<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->unsignedBigInteger('payment_channel_id');
            $table->string('account_name');
            $table->string('account_number');
            $table->unsignedBigInteger('educational_institution_id');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('payment_channel_id')->references('id')->on('payment_channels')->cascadeOnDelete();
            $table->foreign('educational_institution_id')->references('id')->on('educational_institutions')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
