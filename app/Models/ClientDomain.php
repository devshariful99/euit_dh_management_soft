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
    public function domain()
    {
        return $this->belongsTo(Domain::class, 'domain_id');
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
}