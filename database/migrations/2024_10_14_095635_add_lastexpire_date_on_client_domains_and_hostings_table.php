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
        Schema::table('client_domains', function (Blueprint $table) {
            $table->date('last_expire_date')->nullable();
        });
        Schema::table('client_hostings', function (Blueprint $table) {
            $table->date('last_expire_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_domains', function (Blueprint $table) {
            $table->dropColumn('last_expire_date');
        });
        Schema::table('client_hostings', function (Blueprint $table) {
            $table->dropColumn('last_expire_date');
        });
    }
};