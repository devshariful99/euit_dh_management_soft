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
        Schema::table('users', function (Blueprint $table) {
            $table->index('status');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->index('status');
        });
        Schema::table('hostings', function (Blueprint $table) {
            $table->index(['company_id', 'purchase_date', 'expire_date', 'renew_date', 'status'], 'hostings_comp_id_per_dates_status_idx');
        });
        Schema::table('domains', function (Blueprint $table) {
            $table->index(['company_id', 'hosting_id', 'purchase_date', 'expire_date', 'renew_date', 'status', 'is_developed'], 'domains_comh_id_per_dates_status_idx');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');

            $table->index(['hd_id', 'hd_type', 'currency_id'], 'payments_hd_id_hd_type_cur_id_idx');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->index('status');
        });
        Schema::table('client_hostings', function (Blueprint $table) {
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');

            $table->index(['client_id', 'hosting_id', 'purchase_date', 'expire_date', 'renew_date', 'status', 'currency_id'], 'client_hostings_ccuh_id_per_dates_status_idx');
        });
        Schema::table('client_domains', function (Blueprint $table) {
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');

            $table->index(['client_id', 'hosting_id', 'company_id', 'type', 'purchase_date', 'expire_date', 'renew_date', 'status', 'is_developed', 'currency_id'], 'client_domains_ccucoh_id_per_dates_status_idx');
        });
        Schema::table('client_renews', function (Blueprint $table) {
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');

            $table->index(['status', 'hd_id', 'hd_type', 'currency_id'], 'renewals_hd_id_hd_type_cur_id_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_domains', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropIndex(['client_id', 'hosting_id', 'company_id', 'type', 'purchase_date', 'expire_date', 'renew_date', 'status', 'is_developed', 'currency_id']);
            $table->dropColumn('currency_id');
        });

        Schema::table('client_hostings', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropIndex(['client_id', 'hosting_id', 'purchase_date', 'expire_date', 'renew_date', 'status', 'currency_id']);
            $table->dropColumn('currency_id');
        });

        Schema::table('client_renews', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropIndex(['status', 'hd_id', 'hd_type', 'currency_id']);
            $table->dropColumn('currency_id');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropIndex(['hd_id', 'hd_type', 'currency_id']);
            $table->dropColumn('currency_id');
        });

        Schema::table('domains', function (Blueprint $table) {
            $table->dropIndex(['company_id', 'hosting_id', 'purchase_date', 'expire_date', 'renew_date', 'status', 'is_developed']);
        });

        Schema::table('hostings', function (Blueprint $table) {
            $table->dropIndex(['company_id', 'purchase_date', 'expire_date', 'renew_date', 'status']);
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('currencies', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};