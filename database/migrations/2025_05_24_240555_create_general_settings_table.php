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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name');
            $table->string('permission')->nullable();    // Description of the setting
            $table->string('description')->nullable();   // Description of the setting
            $table->string('link')->nullable();          // Description of the setting
            $table->string('image')->nullable();         // Description of the setting
            $table->boolean('is_active')->default(true); // Active status
            $table->timestamps();                        // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
