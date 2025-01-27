<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends AuthBaseModel
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

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
