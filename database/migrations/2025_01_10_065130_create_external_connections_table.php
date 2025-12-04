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
        Schema::create('external_connections', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('token1')->nullable();
            $table->string('token2')->nullable();
            $table->string('token3')->nullable();
            $table->string('token4')->nullable();
            $table->timestamp('last_success_datetime')->nullable();
            $table->timestamp('last_error_datetime')->nullable();
            $table->timestamp('last_action_datetime')->nullable();
            $table->boolean('status_id')->default(false);
              
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_connections');
    }
};
