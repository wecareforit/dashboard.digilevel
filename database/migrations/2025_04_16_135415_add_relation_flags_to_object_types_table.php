<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('object_types', function (Blueprint $table) {
            $table->boolean('has_inspections')->default(false)->after('is_active');
            $table->boolean('has_incidents')->default(false)->after('has_inspections');
            $table->boolean('has_maintencycontracts')->default(false)->after('has_incidents');
            $table->boolean('has_maintency')->default(false)->after('has_maintencycontracts');
            $table->boolean('has_tickets')->default(false)->after('has_maintency');
            $table->boolean('show_on_resource_page')->default(false)->after('has_maintency');
            $table->integer('template_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('object_types', function (Blueprint $table) {
            $table->dropColumn([
                'has_inspections',
                'has_incidents',
                'has_maintencycontracts',
                'has_maintency',
                'has_tickets',
                'show_on_resource_page',
            ]);
        });
    }
};
