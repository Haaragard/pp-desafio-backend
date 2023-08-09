<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\User;
use App\Repositories\Contracts\AccountRepositoryContract;

class AccountRepository extends BaseRepository implements AccountRepositoryContract
{
    /**
     * @param Account $model
     */
    public function __construct(Account $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function createWithUser(User $user): Account
    {
        /**
         * @var Account
         */
        $account = $user->account()->create();

        return $account;
    }
}