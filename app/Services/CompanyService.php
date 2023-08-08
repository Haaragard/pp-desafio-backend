<?php

namespace App\Services;

use App\Dtos\Company\StoreDto;
use App\Models\Company;
use App\Repositories\Contracts\CompanyRepositoryContract;
use App\Services\Contracts\CompanyServiceContract;

class CompanyService implements CompanyServiceContract
{
    /**
     * @param CompanyRepositoryContract $repository
     */
    public function __construct(private CompanyRepositoryContract $repository)
    { }

    /**
     * @inheritDoc
     */
    public function create(StoreDto $dto): Company
    {
        return $this->repository->create($dto->toArray());
    }
}