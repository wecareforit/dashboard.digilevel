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
        Schema::create('object_incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('object_id')->references('id')->on('elevators')->nullable();
            $table->string('subject')->nullable();
            $table->longtext('description')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_phonenumber')->nullable();
            $table->longtext('contact_remark')->nullable();
            $table->integer('standing_still')->nullable();
            $table->integer('priority_id')->nullable();
            $table->integer('status_id')->nullable();

            $table->integer('type_id')->nullable();
            $table->dateTime('report_date_time')->nullable();
 
            $table->timestamps();
            $table->softDeletes();
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
