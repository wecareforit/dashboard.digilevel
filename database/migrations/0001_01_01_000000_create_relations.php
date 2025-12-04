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
        Schema::create('relations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('place')->nullable();
            $table->string('slug')->nullable();
            $table->string('address')->nullable();
            $table->string('emailaddress')->nullable();
            $table->string('phonenumber')->nullable();
            $table->integer('type_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
