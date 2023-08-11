<?php

namespace App\Models;

use App\Models\Traits\HasUuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'approved_at',
        'reproved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'approved_at' => 'datetime',
        'reproved_at' => 'datetime',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * Get the transation amount.
     */
    protected function amountFloat(): Attribute
    {
        return Attribute::make(
            get: fn () => ((float) $this->amount) / 100,
        );
    }

    /**
     * @return BelongsTo
     */
    public function payer(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'payer_id');
    }

    /**
     * @return BelongsTo
     */
    public function payee(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'payee_id');
    }
}
