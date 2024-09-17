<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends BaseModel
{
    use HasFactory;
    public function domains()
    {
        return $this->hasMany(ClientDomain::class, 'client_id', 'id');
    }
    public function renews()
    {
        return $this->hasMany(ClientRenew::class, 'client_id', 'id');
    }
    public function hostings()
    {
        return $this->hasMany(ClientHosting::class, 'client_id', 'id');
    }
}