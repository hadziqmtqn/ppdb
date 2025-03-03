<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('registration_fee_id');
            $table->decimal('amount', 20, 0)->default(0);
            $table->decimal('paid_amount', 20, 0)->default(0);
            $table->decimal('paid_rest', 20, 0)->default(0);
            $table->timestamps();

            $table->foreign('payment_id')
                ->references('id')
                ->on('payments')
                ->cascadeOnDelete();

            $table->foreign('registration_fee_id')
                ->references('id')
                ->on('registration_fees')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
