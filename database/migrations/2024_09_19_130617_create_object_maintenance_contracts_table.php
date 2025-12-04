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
        Schema::create('object_maintenance_contracts', function (Blueprint $table) {
            $table->id();
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->integer('count_of_maintenance')->nullable();
            $table->integer('object_id')->nullable();
            $table->longText('contract')->nullable();
            $table->integer('maintenance_company_id')->nullable();
            $table->longText('remark')->nullable();
              
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('object_maintenance_contracts');
    }
};
