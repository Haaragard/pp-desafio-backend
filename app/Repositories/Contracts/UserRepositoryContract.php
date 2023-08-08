<?php

namespace App\Repositories\Contracts;

use App\Models\Contracts\Userable;
use App\Models\User;

interface UserRepositoryContract extends BaseRepositoryContract
{
    /**
     * @param Userable $userable
     * @param array $attributes
     * @return User
     */
    public function createWithUserable(Userable $userable, array $attributes = []): User;
}