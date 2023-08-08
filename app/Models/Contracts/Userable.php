<?php

namespace App\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface Userable
{
    /**
     * Get the user.
     * 
     * @return MorphOne
     */
    public function user(): MorphOne;

    /**
     * @return string
     */
    public function getCredential(): string;
}