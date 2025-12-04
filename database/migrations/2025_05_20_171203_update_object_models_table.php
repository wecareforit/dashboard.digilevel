<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('object_models', function (Blueprint $table) {
            //  $table->dropColumn('category_id');
            //    $table->integer('type_id')->nullable();
            $table->text('remark')->nullable();
        });
    }

    public function down()
    {
        Schema::table('object_models', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable();
            $table->dropColumn('remark');
        });
    }
};
