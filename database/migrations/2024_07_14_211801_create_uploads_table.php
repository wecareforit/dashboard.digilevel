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
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();   
            $table->integer('module_id')->nullable();
            $table->integer('upload_type_id')->nullable();
	        $table->integer('item_id')->nullable();     
            $table->integer('add_by_user')->nullable();     
            $table->string('directory')->nullable();  
            $table->string('filename')->nullable();   
            $table->string('description')->nullable();
 

            $table->timestamps();
            $table->softDeletes();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploads');
    }
};
