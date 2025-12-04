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
        Schema::table('contacts', function (Blueprint $table) {
            // Adding social media fields
            $table->string('instagram')->nullable()->after('function');
            $table->string('twitter')->nullable()->after('linkedin');
            $table->string('facebook')->nullable()->after('twitter');

            // Adding additional phone and internal number
            $table->string('intern_number', 15)->nullable()->after('mobile_number');

            // Adding address fields
            $table->string('street')->nullable()->after('intern_number');
            $table->string('city')->nullable()->after('street');
            $table->string('postal_code', 10)->nullable()->after('city');
            $table->string('country')->nullable()->after('postal_code');

            // Changing the image column to store a URL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relations', function (Blueprint $table) {

        });
    }
};
