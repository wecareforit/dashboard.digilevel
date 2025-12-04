<?php
// database/migrations/2025_06_03_000000_add_department_id_to_employees_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable()->after('id');
            //    $table->foreign('department_id')('set null');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');
        });
    }
};
