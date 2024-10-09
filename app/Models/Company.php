<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends BaseModel
{
    use HasFactory;
    public function hostings()
    {
        return $this->hasMany(Hosting::class, 'company_id');
    }
    public function domains()
    {
        return $this->hasMany(ClientDomain::class, 'company_id');
    }
}
