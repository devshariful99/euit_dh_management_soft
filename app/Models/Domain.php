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
}
