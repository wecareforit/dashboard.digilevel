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
        Schema::create('external', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->dateTime('last_connection')->nullable();
            $table->string('last_status')->nullable();
            $table->string('last_message')->nullable();
            $table->integer('module_id')->nullable();
 	        $table->boolean('is_active')->nullable()->default('1');
            $table->string('token_1')->nullable();
            $table->string('token_2')->nullable();
	        $table->string('password')->nullable();
              

            $table->timestamps();
            $table->softDeletes(); 



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external');
    }
};
