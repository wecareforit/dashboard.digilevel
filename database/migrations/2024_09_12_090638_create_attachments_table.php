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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('filename');
            $table->string('original_filename')->nullable();
            $table->string('extention')->nullable();
            $table->longtext('description')->nullable();
            $table->string('size')->nullable();
            $table->string('user_id');
            $table->integer('item_id')->nullable();
              
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
