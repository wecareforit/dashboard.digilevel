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
        Schema::create('workorder', function (Blueprint $table) {
            $table->id();
            $table->longtext('description')->nullable()->nullable();
            $table->longtext('internal_description')->nullable()->nullable();
            $table->string('payment_method')->nullable();
            $table->json('employees')->nullable();
            $table->json('materials')->nullable();
            $table->foreignId('project_id')->nullable();
            $table->foreignId('type_id')->nullable();
            $table->foreignId('relation_id')->nullable();
            $table->foreignId('contact_id')->nullable();
            $table->foreignId('status_id')->nullable();
              
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workorder');
    }
};
