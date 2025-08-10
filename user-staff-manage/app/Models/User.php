<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use AnourValar\EloquentSerialize\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public static function booted() {
        static::creating(function ($model) {
            $model->uuid = \Str::uuid();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'uuid',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userToken(): HasMany
    {
        return $this->hasMany(UserToken::class, 'user_id');
    }

    public function currentValidToken(): ?UserToken
    {
        return $this->userToken()
            ->where('is_active', true)
            ->where('expires_at', '>', now())
            ->orderBy('expires_at', 'desc')
            ->first();
    }

    public function createLoginToken()
    {
        if($this->currentValidToken()) {
            // If a valid token already exists, return it
            return $this->currentValidToken();
        }
        $token = UserToken::create([
            'user_id' => $this->id,
            'token' => \Str::random(60),
            'expires_at' => now()->addMinutes(60), // Token valid for 60 minutes
            'is_active' => true,
        ]);

        return $token;
    }

    public function services(): BelongsToMany
    {
//        return $this->hasMany(UserService::class, 'user_id');
        return $this->BelongsToMany(
            SystemService::class,
            UserService::class,
            'user_id',
            'system_service_id'
        );
    }
}
