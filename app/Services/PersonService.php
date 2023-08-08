<?php

namespace App\Services;

use App\Dtos\Person\StoreDto;
use App\Models\Person;
use App\Repositories\Contracts\PersonRepositoryContract;
use App\Services\Contracts\PersonServiceContract;

class PersonService implements PersonServiceContract
{
    /**
     * @param PersonRepositoryContract $repository
     */
    public function __construct(private PersonRepositoryContract $repository)
    { }

    /**
     * @inheritDoc
     */
    public function create(StoreDto $dto): Person
    {
        return $this->repository->create($dto->toArray());
    }
}