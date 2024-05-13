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
        Schema::create('highlight_facilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('facility_id');
            $table->unsignedInteger('homestay_id');
            $table->foreign('facility_id')->references('facility_id')->on('facilities')->onDelete('cascade');
            $table->foreign('homestay_id')->references('homestay_id')->on('homestays')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('highlight_facilities');
    }
};
