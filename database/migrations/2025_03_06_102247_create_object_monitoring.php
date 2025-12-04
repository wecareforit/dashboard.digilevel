<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('object_monitoring', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('sensor01')->nullable();
            $table->string('sensor02')->nullable();
            $table->string('sensor03')->nullable();
            $table->string('sensor04')->nullable();
            $table->string('sensor05')->nullable();
            $table->float('temp01')->nullable();
            $table->float('humidity01')->nullable();
            $table->float('temp02')->nullable();
            $table->float('humidity02')->nullable();
            $table->float('temp03')->nullable();
            $table->float('humidity03')->nullable();
            $table->float('longitude')->nullable();
            $table->float('latitude')->nullable();
            $table->float('lati')->nullable();
            $table->integer('network_signal')->nullable();
            $table->string('protocol')->nullable();
            $table->string('ipaddress')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('object_monitoring');
    }
};