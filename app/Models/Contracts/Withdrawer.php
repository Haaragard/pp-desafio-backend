<?php

namespace App\Models\Contracts;

interface Withdrawer
{
    /**
     * Get verify if has balance above or equals the given amount.
     * 
     * @return bool
     */
    public function hasEnoughBalance(float $amount): bool;
}