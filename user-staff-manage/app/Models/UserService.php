<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class UserService extends Model
{
    //

    protected $fillable = [
        'user_id',
        'system_service_id'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(UserService::class, 'system_service_id');
    }
}
