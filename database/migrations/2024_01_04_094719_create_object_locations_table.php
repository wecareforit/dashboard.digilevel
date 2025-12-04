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
        Schema::create('object_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longtext('image')->nullable();

            $table->string('zipcode')->nullable();     
            $table->string('place')->nullable();
            $table->string('address')->nullable();
            $table->string('slug')->nullable();
            $table->string('complexnumber')->nullable();
            $table->integer('management_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('building_type_id')->nullable();
            
            $table->integer('building_acces_type_id')->nullable();      
            $table->integer('access_type_id')->nullable();
            $table->longtext('remark')->nullable();

            $table->string('access_code')->nullable();
            $table->string('gps_lat')->nullable();
            $table->string('gps_lon')->nullable();
            $table->string('levels')->nullable();
            $table->string('surface')->nullable();
            $table->string('access_contact')->nullable();
            $table->string('location_key_lock')->nullable();
            $table->string('province')->nullable();
            $table->string('municipality')->nullable();
            $table->string('building_type')->nullable();
            $table->string('housenumber')->nullable();
            $table->string('construction_year')->nullable();
            $table->string('building_access_type_id')->nullable();
              
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
