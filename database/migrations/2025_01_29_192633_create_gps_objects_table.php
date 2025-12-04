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
        Schema::create('gps_objects', function (Blueprint $table) {
            $table->id();
            $table->string('imei')->nullable();
            $table->string('active')->nullable();
            $table->string('object_expire')->nullable();
            $table->date('object_expire_dt')->nullable();
            $table->string('name')->nullable();
            $table->string('model')->nullable();
            $table->string('vehicle_id')->nullable();
              
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gps_objects');
    }
};
