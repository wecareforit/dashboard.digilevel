<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('external_uuid')->nullable();
            $table->string('number')->nullable();
            $table->string('type_id')->nullable();
            $table->date('request_date')->nullable();
            $table->date('remembered_at')->nullable();
            $table->date('accepted_at')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('for_company_id')->nullable();
            $table->integer('price')->nullable();
            $table->integer('project_id')->nullable();
            $table->longtext('remark')->nullable();
            $table->longtext('attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
