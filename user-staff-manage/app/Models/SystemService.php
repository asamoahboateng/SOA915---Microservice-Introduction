<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemService extends Model
{
    
    public static function booted() {
        static::creating(function ($model) {
            $model->uuid = \Str::uuid();
        });
    }

    protected $fillable = [
        'service_name',
        'description',
        'uuid'
    ];
}
