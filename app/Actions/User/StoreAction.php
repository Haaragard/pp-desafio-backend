<?php

namespace App\Actions\User;

use App\Dtos\User\StoreDto;
use App\Models\Contracts\Userable;
use App\Models\User;
use App\Services\Contracts\UserServiceContract;

class StoreAction
{
    /**
     * @param UserServiceContract $service
     */
    public function __construct(private UserServiceContract $service)
    { }

    /**
     * @param StoreDto $dto
     * @return User
     */
    public function execute(Userable $userable, StoreDto $dto): User
    {
        return $this->service->create($userable, $dto);
    }
}