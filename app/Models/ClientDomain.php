<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDomain extends BaseModel
{
    use HasFactory;

    /**
     * Get the hosting that owns the ClientDomain
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hosting()
    {
        return $this->belongsTo(Hosting::class, 'hosting_id');
    }
    /**
     * Get the client that owns the ClientDomain
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    /**
     * Get the domain that owns the ClientDomain
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    /**
     * Get the type of the domain
     *
     * @return string
     */

    public function type()
    {
        switch ($this->type) {
            case 1:
                return 'main-domain';
                break;
            case 2:
                return 'sub-domain';
                break;
            case 3:
                return 'custom-domain';
                break;
            default:
                return 'unknown';
                break;
        }
    }

    public function isDeveloped()
    {
        if ($this->is_developed == 1) {
            return 'Yes';
        } else {
            return 'No';
        }
    }

    public function isDevelopedBadge()
    {
        if ($this->is_developed == 1) {
            return 'badge badge-success';
        } else {
            return 'badge badge-warning';
        }
    }

    public function renews()
    {
        return $this->morphMany(ClientRenew::class, 'hd');
    }
}