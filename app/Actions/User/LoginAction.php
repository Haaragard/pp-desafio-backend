<?php

namespace App\Actions\User;

use App\Dtos\User\LoginDto;
use App\Exceptions\AutheticatableCredentialsDoesNotMatchException;
use App\Models\User;
use App\Services\Contracts\UserServiceContract;

class LoginAction
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
    public function execute(LoginDto $dto): string
    {
        $user = $this->getUserByEmail($dto->email);

        $passwordValidated = $this->checkPasswordMatch($user, $dto->password);
        if (! $passwordValidated) {
            throw new AutheticatableCredentialsDoesNotMatchException;
        }

        $newAccessToken = $this->newPersonalAccessToken($user);

        return $newAccessToken;
    }

    /**
     * @param string $email
     * @return User
     */
    private function getUserByEmail(string $email): User
    {
        return $this->service->getByEmail($email);
    }

    /**
     * @param User $user
     * @param string $password
     * @return bool
     */
    private function checkPasswordMatch(User $user, string $password): bool
    {
        return $this->service->checkPasswordMatch($user, $password);
    }

    /**
     * @param User $user
     * @return string
     */
    private function newPersonalAccessToken(User $user): string
    {
        return $this->service->newPersonaAccessToken($user);
    }
}