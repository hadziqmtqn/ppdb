<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('place_of_recidences', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug');
            $table->unsignedBigInteger('user_id');
            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->string('village');
            $table->string('street');
            $table->string('postal_code');
            $table->unsignedBigInteger('distance_to_school_id');
            $table->unsignedBigInteger('transportation_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('distance_to_school_id')->references('id')->on('distance_to_schools')->cascadeOnDelete();
            $table->foreign('transportation_id')->references('id')->on('transportations')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('place_of_recidences');
    }
};
