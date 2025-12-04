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
        Schema::create('relation_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longtext('image')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('place')->nullable();
            $table->string('address')->nullable();
            $table->string('slug')->nullable();
            $table->string('complexnumber')->nullable();
            $table->integer('type_id')->nullable();
            $table->integer('relation_id')->nullable();
            $table->integer('building_type_id')->nullable();
            $table->integer('management_id')->nullable();
            $table->longtext('remark')->nullable();
            $table->string('gps_lat')->nullable();
            $table->string('gps_lon')->nullable();
            $table->string('province')->nullable();
            $table->string('municipality')->nullable();
            $table->string('building_type')->nullable();
            $table->string('housenumber')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relation_location');
    }
};
