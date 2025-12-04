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
        Schema::table('relation_types', function (Blueprint $table) {
            $table->boolean('has_tickets')->nullable();
            $table->boolean('has_contacts')->nullable();
            $table->boolean('has_timeregistration')->nullable();
            $table->boolean('has_projects')->nullable();
            $table->boolean('has_objects')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('object_types', function (Blueprint $table) {
            //
        });
    }
};
