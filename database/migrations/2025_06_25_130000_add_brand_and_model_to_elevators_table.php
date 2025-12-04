<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('elevators', function (Blueprint $table) {
            $table->string('brand')->nullable()->after('id');
            $table->string('model')->nullable()->after('brand');
            $table->string('drive_type')->nullable();
            

        });
    }

    public function down(): void
    {
        Schema::table('elevators', function (Blueprint $table) {
            $table->dropColumn(['brand', 'model']);
        });
    }
};