<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientHosting extends BaseModel
{
    use HasFactory;

    /**
     * Get the hosting that owns the ClientHosting
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hosting()
    {
        return $this->belongsTo(Hosting::class, 'hosting_id');
    }
    /**
     * Get the client that owns the ClientHosting
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function renews()
    {
        return $this->morphMany(ClientRenew::class, 'hd');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}