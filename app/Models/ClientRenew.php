<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRenew extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'status',
    ];
    public function hd()
    {
        return $this->morphTo();
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}