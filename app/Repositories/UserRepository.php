<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;

class UserRepository extends BaseRepository implements UserRepositoryContract
{
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}