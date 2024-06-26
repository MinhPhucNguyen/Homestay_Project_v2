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

        if(!Schema::hasTable('rooms_images')){
            Schema::create('rooms_images', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('room_id')->nullable();
                $table->string('path');
                $table->timestamps();

                $table->foreign('room_id')->references('room_id')->on('rooms')->onDelete('cascade');
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms_images');
    }
};
