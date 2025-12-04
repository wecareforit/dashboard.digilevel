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
        Schema::create('upload_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longtext('image')->nullable();
            $table->boolean('is_active')->nullable()->default('1');
            $table->boolean('visible_projects')->nullable()->default('0');
            $table->boolean('visible_incidents')->nullable()->default('0');
            $table->boolean('visible_assets')->nullable()->default('0');
            $table->boolean('visible_tools')->nullable()->default('0');
            $table->boolean('visible_workorders')->nullable()->default('0');
            $table->boolean('visible_fleet')->nullable()->default('0');
            $table->boolean('visible_object_management_companies')->nullable()->default('0');
            $table->boolean('visible_object_suppliers')->nullable()->default('0');
            $table->boolean('visible_object_maintenance_companies')->nullable()->default('0');
            $table->boolean('visible_object_attachments')->nullable()->default('0');
              

            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
