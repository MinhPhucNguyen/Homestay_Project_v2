<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('homestays_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('homestay_id')->nullable();
            $table->unsignedInteger('room_id')->nullable();
            $table->string('path');
            $table->timestamps();

            $table->foreign('homestay_id')->references('homestay_id')->on('homestays')->onDelete('cascade');
            $table->foreign('room_id')->references('room_id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homestays_images');
    }
};
