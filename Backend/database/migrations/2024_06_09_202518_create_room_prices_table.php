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
        Schema::create('room_prices', function (Blueprint $table) {
            $table->increments('room_price_id');
            $table->unsignedInteger('homestay_id');
            $table->unsignedInteger('room_type_id');
            $table->foreign('homestay_id')->references('homestay_id')->on('homestays')->onDelete('cascade');
            $table->foreign('room_type_id')->references('room_type_id')->on('room_types')->onDelete('cascade');
            $table->decimal('price_per_day', 10, 0)->default(0);
            $table->decimal('price_per_hour', 10, 0)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_prices');
    }
};
