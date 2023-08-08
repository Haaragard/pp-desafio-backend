<?php

namespace App\Models;

use App\Models\Contracts\Userable;
use App\Models\Traits\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Company extends Model implements Userable
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cnpj',
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
     * @inheritdoc
     */
    public function getCredential(): string
    {
        return $this->cnpj;
    }

    /**
     * @inheritDoc
     */
    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }
}
