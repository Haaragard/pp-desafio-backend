<?php

namespace App\Services;

use App\Dtos\User\StoreDto;
use App\Models\Contracts\Userable;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\Contracts\UserServiceContract;

class UserService implements UserServiceContract
{
    /**
     * @param UserRepositoryContract $repository
     */
    public function __construct(private UserRepositoryContract $repository)
    { }

    /**
     * @inheritDoc
     */
    public function create(Userable $userable, StoreDto $dto): User
    {
        return $this->repository->createWithUserable($userable, $dto->toArray());
    }
}