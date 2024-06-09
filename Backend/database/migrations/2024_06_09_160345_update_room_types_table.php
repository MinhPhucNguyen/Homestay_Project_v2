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
        Schema::table('room_types', function (Blueprint $table) {
//            $table->renameColumn('price_per_night', 'price_per_day');
        });

        Schema::table('room_types', function (Blueprint $table) {
//            $table->integer('number_of_beds')->after('description');
//            $table->decimal('price_per_day', 10, 0)->change();
//            $table->decimal('price_per_hour', 10, 0)->after('price_per_day')->change();
//            $table->text('description')->nullable()->change();

//            $table->dropColumn('area');
//            $table->dropColumn('room_type');
//            $table->dropColumn('occupancy');
            $table->dropColumn('price_per_day');
            $table->dropColumn('price_per_hour');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_types', function (Blueprint $table) {
            $table->decimal('area', 10, 2)->after('price_per_day');
            $table->integer('capacity')->after('area');
        });

        Schema::table('room_types', function (Blueprint $table) {
            $table->dropColumn('number_of_beds');
            $table->dropColumn('price_per_hour');
        });

        Schema::table('room_types', function (Blueprint $table) {
            $table->renameColumn('price_per_day', 'price_per_night');
        });
    }
};
