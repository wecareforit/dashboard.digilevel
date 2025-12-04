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
        Schema::create('project_reactions', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->longtext('reaction')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('status_id')->nullable();
              
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_reactions');
    }
};
