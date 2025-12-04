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
        Schema::create('elevator_inspection_data', function (Blueprint $table) {
            $table->id();
            $table->integer('action_id')->nullable();
            $table->integer('inspection_id')->nullable();
            $table->string('zin_code')->nullable();
            $table->longtext('comment')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->string('schedule_run_token')->nullable();
              

            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('object_inspection_data');
    }
};
