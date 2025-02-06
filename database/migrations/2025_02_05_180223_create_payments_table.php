<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->integer('serial_number')->unique();
            $table->string('code')->unique();
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount', 20, 0)->default(0);
            $table->string('checkout_link')->nullable();
            $table->string('status');
            $table->string('payment_method')->nullable();
            $table->string('payment_channel')->nullable();
            $table->unsignedBigInteger('bank_account_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('bank_account_id')
                ->references('id')
                ->on('bank_accounts')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
