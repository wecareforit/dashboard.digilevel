<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('relation_types', function (Blueprint $table) {
            $table->integer('sort')->default(0)->after('id'); // change 'id' to the appropriate column
        });
    }

    public function down(): void
    {
        Schema::table('relation_types', function (Blueprint $table) {
            $table->dropColumn('sort');
        });
    }
};
