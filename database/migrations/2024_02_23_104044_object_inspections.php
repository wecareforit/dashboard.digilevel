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
        Schema::create('object_inspections', function (Blueprint $table) {
            $table->id();
            $table->date('executed_datetime')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('status_id')->nullable();
            $table->longtext('remark')->nullable();
            $table->longtext('document')->nullable();
            $table->longtext('certification')->nullable();
            $table->integer('object_id')->references('id')->on('elevators')->nullable();
            $table->string('inspection_company_id')->nullable();
            $table->string('nobo_number')->nullable();
            $table->string('if_match')->nullable();
            $table->string('type')->nullable();
            $table->string('external_uuid')->nullable();
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
      
    }
};
