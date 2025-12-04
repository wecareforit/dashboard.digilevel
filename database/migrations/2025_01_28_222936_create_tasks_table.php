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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longtext('description')->nullable();
            $table->string('model')->nullable();
            $table->integer('model_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->integer('make_by_employee_id')->nullable();
            $table->string('priority')->nullable();
            $table->date('begin_date')->nullable();
            $table->date('deadline')->nullable();
            $table->time('end_time')->nullable();
            $table->time('begin_time')->nullable();
            $table->integer('private')->nullable();
            $table->integer('type_id')->nullable();
              
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
