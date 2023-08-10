<?php

namespace App\Rules;

use App\Models\Account;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class HasEnoughBalance implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $account = $this->getAccount();

        if (! $account->hasEnoughBalance($value)) {
            $fail('validation.account.balance.not_enough')->translate();
        }
    }

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
        $user = $this->getUser();

        return $user->account;
    }
}
