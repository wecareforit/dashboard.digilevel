<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->integer('team_id')->nullable();

            // Optional: Update primary key if necessary
            // $table->dropPrimary(); // drops the old composite primary key
            // $table->primary(['role_id', 'model_type', 'model_id', 'team_id']);
        });
    }

    public function down(): void
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            // $table->dropPrimary(); // drop the updated primary key
            // $table->dropColumn('team_id');

            // // Restore original primary key
            // $table->primary(['role_id', 'model_type', 'model_id']);
        });
    }
};
