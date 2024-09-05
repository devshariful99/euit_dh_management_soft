<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends BaseModel
{
    use HasFactory;

    public function hd()
    {
        return $this->morphTo();
    }
    public function scopeDomain_or_hosting_name(){
        return $this->hd->name;
    }
}
