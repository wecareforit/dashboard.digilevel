<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('elevators', function (Blueprint $table) {
            $table->foreignId('model_id')->nullable();
            // You can remove `nullable()` and adjust `onDelete` depending on your use case.
        });
    }

    public function down(): void
    {
        Schema::table('elevators', function (Blueprint $table) {

            $table->dropColumn('model_id');
        });
    }
};
