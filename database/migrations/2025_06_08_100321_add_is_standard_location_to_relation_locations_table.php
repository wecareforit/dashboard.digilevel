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
        Schema::table('relation_locations', function (Blueprint $table) {
            $table->boolean('is_standard_location')->default(false); // Replace 'your_existing_column' with the actual column name to position after

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relation_locations', function (Blueprint $table) {
            $table->dropColumn('is_standard_location');
        });
    }
};
