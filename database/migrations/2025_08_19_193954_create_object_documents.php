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
        Schema::create('object_documents', function (Blueprint $table) {
        $table->id();
        $table->foreignId('object_id');
        $table->foreignId('employee_id');
        $table->string('status_id')->nullable();
        $table->integer('created_by_user_id');
        $table->string('signed_ipaddress')->nullable();
        $table->date('signed_at')->nullable();
        $table->longtext('signed_signature')->nullable();
        $table->date('cancelled_at')->nullable();
        $table->longtext('cancelled_remark')->nullable();
        $table->integer('cancelled_by_user_id')->nullable();
        $table->longtext('cancelled_signature')->nullable();
        $table->longtext('cancelled_reason')->nullable();

        $table->softDeletes();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('object_documents');
    }
};



 