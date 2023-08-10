<?php

namespace App\Actions\Traits;

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait AuthUtilities
{
    /**
     * @return User
     */
    private function getUser(): User
    {
        return Auth::user();
    }

    /**
     * @return Account
     */
    private function getAccount(): Account
    {
        /**
         * @var User
         */
        $user = $this->getUser();

        return $user->account;
    }
}