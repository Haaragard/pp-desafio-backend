<?php

namespace App\Models;

use App\Models\Contracts\Withdrawer;
use App\Models\Traits\HasUuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model implements Withdrawer
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'balance',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * Get the account balance in float.
     */
    protected function balanceFloat(): Attribute
    {
        return Attribute::make(
            get: fn () => ((float) $this->balance) / 100,
        );
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * @inheritDoc
     */
    public function hasEnoughBalance(float $amount): bool
    {
        return $this->balance >= ($amount * 100);
    }
}
