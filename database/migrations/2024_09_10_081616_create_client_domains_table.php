<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\AuditColumnsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    use AuditColumnsTrait, SoftDeletes;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_domains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('hosting_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('domain_name');
            $table->tinyInteger('type')->comment('1 = main-domain, 2 = sub-domain, 3 = custom-domain');
            $table->double('price', 8, 2);
            $table->string('admin_url');
            $table->string('username')->nullable();
            $table->string('email');
            $table->string('password');
            $table->date('purchase_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->date('renew_date')->nullable();
            $table->longText('note')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('is_developed')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $this->addAuditColumns($table);

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('hosting_id')->references('id')->on('hostings')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_domains');
    }
};