<?php

namespace App\Services;

use App\Repositories\Contracts\CompanyRepositoryContract;
use App\Services\Contracts\CompanyServiceContract;

class CompanyService implements CompanyServiceContract
{
    /**
     * @param CompanyRepositoryContract $repository
     */
    public function __construct(private CompanyRepositoryContract $repository)
    { }
}