<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFirewallIpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firewall_ips', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip');
            $table->integer('log_id')->nullable();
            $table->boolean('blocked')->default(1);
            $table->integer('prefix_size')->nullable();
            $table->index('ip');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('firewall_ips');
    }
}
