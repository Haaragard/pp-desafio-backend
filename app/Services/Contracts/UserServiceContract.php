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

    /**
     * @param string $email
     * @return User
     */
    public function getByEmail(string $email): User;

    /**
     * @param User $user
     * @param string $password
     * @return bool
     */
    public function checkPasswordMatch(User $user, string $password): bool;

    /**
     * @param User $user
     * @return string
     */
    public function newPersonaAccessToken(User $user): string;
}