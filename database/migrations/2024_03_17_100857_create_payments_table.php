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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum('payment_for',['Hosting','Domain']);
            $this->addHostingDomainMorphedAuditColumns($table);
            $table->enum('payment_type',['First-payment','Renew-payment','Due-payment']);
            $table->date('payment_date');
            $table->float('price');
            $table->enum('duration_type',['Month','Year']);
            $table->string('file')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $this->addAuditColumns($table);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
