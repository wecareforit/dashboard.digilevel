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
        Schema::table('time_tracking', function (Blueprint $table) {
            $table->foreignId('relation_id')->nullable();
            $table->longtext('description')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('weekno')->nullable();
            $table->integer('work_type_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->time('time')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_tracking', function (Blueprint $table) {
            //
        });
    }
};
