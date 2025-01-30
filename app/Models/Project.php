<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends BaseModel
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function hosting()
    {
        return $this->belongsTo(ClientHosting::class);
    }
    public function domain()
    {
        return $this->belongsTo(ClientDomain::class);
    }
    public function credentials()
    {
        return $this->hasMany(ProjectCredential::class);
    }
}
