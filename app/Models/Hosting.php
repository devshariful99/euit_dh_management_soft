<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hosting extends BaseModel
{
    use HasFactory;
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function domains()
    {
        return $this->hasMany(Domain::class, 'hosting_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'hd_id');
    }
}
