<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('registration_fees', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->unsignedBigInteger('educational_institution_id');
            $table->unsignedBigInteger('school_year_id');
            $table->enum('type_of_payment', ['sekali_bayar', 'kredit']);
            $table->string('name');
            $table->enum('registration_status', ['siswa_belum_diterima', 'siswa_diterima']);
            $table->decimal('amount', 20, 0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('educational_institution_id')
                ->references('id')
                ->on('educational_institutions')
                ->restrictOnDelete();

            $table->foreign('school_year_id')
                ->references('id')
                ->on('school_years')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_fees');
    }
};
