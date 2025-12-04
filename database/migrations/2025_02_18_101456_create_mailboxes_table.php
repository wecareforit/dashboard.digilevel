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
        Schema::create('mailboxes', function (Blueprint $table) {
            $table->id();
            $table->string('server');
            $table->string('email');
            $table->string('password');
            $table->integer('portnumber'); 
            $table->string('security_protocol');
            ; 
            $table->datetime('last_success_at')->nullable();; 
            $table->datetime('last_error_at')->nullable();;
            $table->string('last_error_message')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mailboxes');
    }
};
