<?php
// app/Models/Booking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_phone',
        'service_id',
        'booking_date',
        'booking_time',
        'status',
        'notes',
        'client_email',
        'uuid',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'booking_time' => 'datetime',
    ];

    protected $with = ['service'];

    public static function booted() {
        static::creating(function ($model) {
            do {
                $uuid = \Str::uuid();
            } while (self::where('uuid', $uuid)->exists());

            $model->uuid = $uuid;
        });
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }


}
