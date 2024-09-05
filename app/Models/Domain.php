<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends BaseModel
{
    use HasFactory;
    public function getDevelopedStatus()
    {
        if ($this->is_developed == 1) {
            return 'Developed';
        } else {
            return 'Not Developed';
        }
    }
    public function getDevelopedStatusIcon()
    {
        if ($this->is_developed == 1) {
            return 'fa-solid fa-xmark';
        } else {
            return 'fa-solid fa-check';
        }
    }
    public function getDevelopedStatusTitle()
    {
        if ($this->is_developed == 1) {
            return 'Make Not Developed';
        } else {
            return 'Make Developed';
        }
    }

    public function getDevelopedStatusClass()
    {
        if ($this->is_developed == 1) {
            return 'btn btn-secondary';
        } else {
            return 'btn btn-info';
        }
    }
    public function getDevelopedStatusBadgeClass()
    {
        if ($this->is_developed == 1) {
            return 'badge badge-info';
        } else {
            return 'badge badge-warning';
        }
    }



    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function hosting()
    {
        return $this->belongsTo(Hosting::class, 'hosting_id');
    }
}
