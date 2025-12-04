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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('model_id')->nullable();
            $table->longtext('title')->nullable();
            $table->longtext('description')->nullable();
            $table->integer('prio')->nullable();
            $table->integer('type_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->foreignId('created_by_user')->nullable();
            $table->foreignId('assigned_by_user')->nullable();
            $table->integer('model')->nullable();
              
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
