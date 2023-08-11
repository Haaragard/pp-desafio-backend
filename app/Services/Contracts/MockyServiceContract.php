<?php

namespace App\Services\Contracts;

interface MockyServiceContract
{
    /**
     * @return bool
     */
    public function transactionIsAuthorized(): bool;
}