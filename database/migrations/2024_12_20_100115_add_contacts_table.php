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
        Schema::create('contacts', function (Blueprint $table) {
            $table->longtext('image')->nullable();
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('department')->nullable();
            $table->string('company')->nullable();
            $table->string('function')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->string('mobile_number', 15)->nullable();
              
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
