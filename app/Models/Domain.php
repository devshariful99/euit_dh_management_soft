<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends BaseModel
{
    use HasFactory;
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function hosting()
    {
        return $this->belongsTo(Hosting::class, 'hosting_id');
    }
    public function payments()
    {
        return $this->hasMany(Domain::class, 'hd_id')->where('hd_type', get_class($this));
    }
}
