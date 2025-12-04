<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateApiLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Step 0: Add new columns first
        Schema::table('api_logs', function (Blueprint $table) {
            $table->longText('payload_raw')->nullable()->after('payload');
            $table->longText('response_headers')->after('response');
            $table->text('headers')->nullable()->after('response');
        });

      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_logs', function (Blueprint $table) {
            $table->dropColumn('response');
            $table->dropColumn('response_headers');
            $table->dropColumn('payload_raw');
            $table->dropColumn('headers');
        });


    }
}