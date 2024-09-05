<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\AuditColumnsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    use AuditColumnsTrait, SoftDeletes;
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('website_url');
            $table->boolean('status')->default(1);
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes(); 
            $this->addAuditColumns($table);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
