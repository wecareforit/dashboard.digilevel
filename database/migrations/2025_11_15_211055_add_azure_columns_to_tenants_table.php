<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('azure_client_id')->nullable()->after('name');
            $table->string('azure_client_secret')->nullable()->after('azure_client_id');
            $table->string('azure_redirect_uri')->nullable()->after('azure_client_secret');
            $table->string('azure_tenant_id')->nullable()->after('azure_redirect_uri');
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'azure_client_id',
                'azure_client_secret',
                'azure_redirect_uri',
                'azure_tenant_id'
            ]);
        });
    }
};