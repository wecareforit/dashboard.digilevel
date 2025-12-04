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

        Schema::dropIfExists('object_monitoring');
        Schema::create('object_monitoring', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('external_object_id')->nullable();
            $table->string('category')->nullable();
            $table->string('param01')->nullable();
            $table->string('param02')->nullable();
            $table->string('brand')->nullable();
            $table->string('value')->nullable();
            $table->datetime('date_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('object_monitoring');
    }
};
