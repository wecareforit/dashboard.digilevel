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
        Schema::create('object_monitoring_codes', function (Blueprint $table) {
            $table->id();
            $table->string('brand')->nullable();
            $table->string('error_code')->nullable();
            $table->longtext('description')->nullable();
            $table->longtext('possreason')->nullable();
            $table->longtext('detection')->nullable();
            $table->longtext('operation')->nullable();
            $table->longtext('recovery')->nullable();
            $table->softDeletes();
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
