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
            $table->double('price', 8, 2)->nullable()->change();
            $table->string('admin_url')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('password')->nullable()->change();
            $table->tinyInteger('purchase_type')->default(1)->comment('1 = Purchase From Us, 2 = Purchase From Others');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_domains', function (Blueprint $table) {
            $table->double('price', 8, 2)->change();
            $table->string('admin_url')->change();
            $table->string('email')->change();
            $table->string('password')->change();
            $table->dropColumn('purchase_type');
        });
    }
};