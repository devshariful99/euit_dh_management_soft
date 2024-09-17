<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRenew extends Model
{
    use HasFactory;
    public function hd()
    {
        return $this->morphTo();
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}