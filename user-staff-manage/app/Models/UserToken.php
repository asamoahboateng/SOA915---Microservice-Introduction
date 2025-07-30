<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
        'is_active'
    ];

    public function user(): BelongsTo
    {
        $this->belongsTo(User::class, 'user_id');
    }
}
