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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('hosting_id')->nullable();
            $table->unsignedBigInteger('domain_id')->nullable();
            $table->json('credentials')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('hosting_id')->references('id')->on('hostings')->onDelete('cascade');
            $table->foreign('domain_id')->references('id')->on('domains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
