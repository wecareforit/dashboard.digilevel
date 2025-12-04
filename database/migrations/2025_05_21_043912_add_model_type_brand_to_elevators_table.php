<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('elevators', function (Blueprint $table) {

            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('uuid')->nullable();
            $table->string('employee_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('elevators', function (Blueprint $table) {
          //  $table->dropColumn(['model_id', 'type_id', 'brand_id']);
        });
    }
};
