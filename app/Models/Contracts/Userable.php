<?php

namespace App\Models\Contracts;

interface Userable
{
    /**
     * @return string
     */
    public function getCredential(): string;
}