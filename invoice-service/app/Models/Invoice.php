<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_email',
        'client_phone', // Added client_phone
        'service_name',
        'service_id',
        'cost',
        'status',
        'uuid',
        'booking_id'
    ];

    public static function booted() {
        static::creating(function ($model) {
            do {
                $uuid = \Str::uuid();
            } while (self::where('uuid', $uuid)->exists());

            $model->uuid = $uuid;
        });
    }
}
