<?php

namespace App\Repositories;

use App\Models\Contracts\Userable;
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

    /**
     * @inheritDoc
     */
    public function createWithUserable(Userable $userable, array $attributes = []): User
    {
        /**
         * @var User
         */
        $user = new $this->model;
        $user->userable()->associate($userable);
        $user->fill($attributes);
        $user->save();

        return $user;
    }
}