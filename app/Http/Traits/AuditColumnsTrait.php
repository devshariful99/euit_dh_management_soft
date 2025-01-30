<?php

namespace App\Http\Traits;

use Illuminate\Database\Schema\Blueprint;

trait AuditColumnsTrait
{

    public function addAuditColumns(Blueprint $table): void
    {
        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('updated_by')->nullable();
        $table->unsignedBigInteger('deleted_by')->nullable();

        $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
    }

    public function addHostingDomainMorphedAuditColumns(Blueprint $table): void
    {
        $table->unsignedBigInteger('hd_id')->nullable();
        $table->string('hd_type')->nullable();
    }
    public function dropHostingDomainMorphedAuditColumns(Blueprint $table): void
    {
        $table->dropColumn('hd_id');
        $table->dropColumn('hd_type');
    }
    public function dropAuditColumns(Blueprint $table): void
    {

        $table->dropForeign('created_by');
        $table->dropForeign('updated_by');
        $table->dropForeign('deleted_by');
    }

    public function addClientAuditColumns(Blueprint $table): void
    {
        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('updated_by')->nullable();
        $table->unsignedBigInteger('deleted_by')->nullable();

        $table->foreign('created_by')->references('id')->on('cleints')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('updated_by')->references('id')->on('cleints')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('deleted_by')->references('id')->on('cleints')->onDelete('cascade')->onUpdate('cascade');
    }
    public function dropClientAuditColumns(Blueprint $table): void
    {

        $table->dropForeign('created_by');
        $table->dropForeign('updated_by');
        $table->dropForeign('deleted_by');
    }

    public function addMorphedAuditColumns(Blueprint $table): void
    {
        $table->unsignedBigInteger('creater_id')->nullable();
        $table->string('creater_type')->nullable();

        $table->unsignedBigInteger('updater_id')->nullable();
        $table->string('updater_type')->nullable();

        $table->unsignedBigInteger('deleter_id')->nullable();
        $table->string('deleter_type')->nullable();
    }
    public function dropMorphedAuditColumns(Blueprint $table): void
    {
        $table->dropColumn(['creater_id', 'creater_type', 'updater_id', 'updater_type', 'deleter_id', 'deleter_type']);
    }
}