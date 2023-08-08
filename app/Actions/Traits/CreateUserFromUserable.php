<?php

namespace App\Actions\Traits;

use App\Actions\User\StoreAction;
use App\Dtos\User\StoreDto;
use App\Models\Contracts\Userable;
use App\Models\User;

trait CreateUserFromUserable
{
    protected StoreAction $storeUserAction;

    /**
     * @param Userable $userable
     * @param StoreDto $dto
     * @return User
     */
    private function createUser(Userable $userable, StoreDto $dto): User
    {
        return $this->storeUserAction->execute($userable, $dto);
    }
}