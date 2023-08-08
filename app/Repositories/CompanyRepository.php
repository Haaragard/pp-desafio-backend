<?php

namespace App\Repositories;

use App\Models\Company;
use App\Repositories\Contracts\CompanyRepositoryContract;

class CompanyRepository extends BaseRepository implements CompanyRepositoryContract
{
    /**
     * @param Company $model
     */
    public function __construct(Company $model)
    {
        parent::__construct($model);
    }
}