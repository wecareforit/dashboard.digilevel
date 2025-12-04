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
        Schema::create('gps_object_data', function (Blueprint $table) {
            $table->id();
            $table->dateTime('dt_server')->nullable();
            $table->dateTime('dt_tracker')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('altitude')->nullable();
            $table->string('angle')->nullable();
            $table->string('speed')->nullable();
            $table->string('params_gpslev')->nullable();
            $table->string('params_pump')->nullable();
            $table->string('params_track')->nullable();
            $table->string('params_bats')->nullable();
            $table->string('params_acc')->nullable();
            $table->string('params_batl')->nullable();
            $table->string('loc_valid')->nullable();
            $table->string('imei')->nullable();

            $table->string('streetNameAndNumber')->nullable();
            $table->string('countryCode')->nullable();
            $table->string('municipalitySubdivision')->nullable();
            $table->string('countryCodeISO3')->nullable();
            $table->string('countrySubdivisionName')->nullable();
            $table->string('countrySubdivisionCode')->nullable();

            $table->string('zipcode')->nullable();
            $table->string('km_start')->nullable();
            $table->string('km_end')->nullable();
            $table->string('customer_id')->nullable();

            $table->string('vehicle_id')->nullable();
            //   
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gps_object_data');
    }
};
