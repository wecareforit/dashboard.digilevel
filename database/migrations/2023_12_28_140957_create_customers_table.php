<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); 
            $table->dateTime('last_edit_at')->nullable();
            $table->integer('last_edit_by')->nullable();
            $table->string('name')->nullable();
            $table->string('zipcode')->nullable();     
            $table->string('place')->nullable();
            $table->string('slug')->nullable();
            $table->string('address')->nullable();
            $table->string('emailaddress')->nullable();
            $table->string('phonenumber')->nullable();

            $table->string('api_uuid')->nullable();
            $table->string('api_url')->nullable();
            $table->string('source')->nullable();
            $table->string('bic')->nullable();
            $table->string('iban')->nullable();
            $table->string('language')->nullable();
            $table->string('country')->nullable();
            $table->boolean('is_active')->nullable()->default('1');
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
        Schema::dropIfExists('customers');
    }
};
