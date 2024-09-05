<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use HasFactory, SoftDeletes;
    public function created_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updated_user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function deleted_user()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    public function getStatus()
    {
        if ($this->status == 1) {
            return 'Active';
        } else {
            return 'Deactive';
        }
    }
    public function getStatusTitle()
    {
        if ($this->status == 1) {
            return 'Deactive';
        } else {
            return 'Active';
        }
    }

    public function getStatusClass()
    {
        if ($this->status == 1) {
            return 'btn btn-warning';
        } else {
            return 'btn btn-success';
        }
    }
    public function getStatusBadgeClass()
    {
        if ($this->status == 1) {
            return 'badge badge-success';
        } else {
            return 'badge badge-warning';
        }
    }
    public function scopeActivated($query){
        return $query->where('status',1);
    }
    public function scopeCreated_user_name(){
        return $this->created_user->name ?? 'System';
    }
    public function scopeUpdated_user_name(){
        return $this->updated_user->name ?? '--';
    }
    public function scopeDeleted_user_name(){
        return $this->deleted_user->name ?? '--';
    }
    public function scopeCreated_date(){
        return timeFormate($this->created_at);
    }
    public function scopeUpdated_date(){
        return ($this->updated_at != $this->created_at) ? timeFormate($this->updated_at) : '--';
    }
    public function scopeDeleted_date(){
        return timeFormate($this->deleted_at);
    }
}
