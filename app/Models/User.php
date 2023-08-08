<?php

namespace App\Models;

use App\Models\Traits\HasUuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'phone_verified_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the parent userable model
     * [
     *      \App\Models\Person::class,
     * ]
     * @return MorphTo
     */
    public function userable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get if the user is a person.
     */
    protected function isPerson(): Attribute
    {
        return Attribute::make(
            get: fn () => (bool) ($this->userable_type === Person::class)
        );
    }

    /**
     * Get if the user is a company.
     */
    protected function isCompany(): Attribute
    {
        return Attribute::make(
            get: fn () => (bool) ($this->userable_type === Company::class)
        );
    }
}
