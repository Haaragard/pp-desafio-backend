<?php

namespace App\Services;

use App\Dtos\User\StoreDto;
use App\Models\Contracts\Userable;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\Contracts\UserServiceContract;
use Illuminate\Support\Facades\DB;

class UserService implements UserServiceContract
{
    /**
     * @var int
     */
    private const PERSONAL_ACCESS_TOKEN_EXPIRATION_HOURS = 5;

    /**
     * @param UserRepositoryContract $repository
     */
    public function __construct(private UserRepositoryContract $repository)
    { }

    /**
     * @inheritDoc
     */
    public function create(Userable $userable, StoreDto $dto): User
    {
        return $this->repository->createWithUserable($userable, $dto->toArray());
    }

    /**
     * @inheritDoc
     */
    public function getByEmail(string $email): User
    {
        return $this->repository->findBy('email', $email, true);
    }

    /**
     * @inheritDoc
     */
    public function checkPasswordMatch(User $user, string $password): bool
    {
        $userHashedPassword = $user->getAuthPassword();

        return password_verify($password, $userHashedPassword);
    }

    /**
     * @inheritDoc
     */
    public function newPersonaAccessToken(User $user): string
    {
        $token = $user->createToken(
            'login',
            expiresAt: now()->addHours(self::PERSONAL_ACCESS_TOKEN_EXPIRATION_HOURS)
        );

        return $token->plainTextToken;
    }
}