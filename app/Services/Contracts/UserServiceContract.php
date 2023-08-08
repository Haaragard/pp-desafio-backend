<?php

namespace App\Services\Contracts;

use App\Dtos\User\StoreDto;
use App\Models\Contracts\Userable;
use App\Models\User;

interface UserServiceContract
{
    /**
     * @param Userable $userable
     * @param StoreDto $dto
     * @return User
     */
    public function create(Userable $userable, StoreDto $dto): User;
}