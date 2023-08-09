<?php

namespace App\Actions\Person;

use App\Actions\Account\StoreAction as AccountStoreAction;
use App\Actions\Traits\CreateAccountFromUser;
use App\Actions\Traits\CreateUserFromUserable;
use App\Actions\User\StoreAction as UserStoreAction;
use App\Dtos\Person\StoreDto;
use App\Dtos\User\StoreDto as UserStoreDto;
use App\Models\Person;
use App\Services\Contracts\PersonServiceContract;
use Illuminate\Support\Facades\DB;

class StoreAction
{
    use CreateUserFromUserable;
    use CreateAccountFromUser;

    /**
     * @param PersonServiceContract $service
     * @param UserStoreAction $storeUserAction
     * @param AccountStoreAction $storeAccountAction
     */
    public function __construct(
        private PersonServiceContract $service,
        private UserStoreAction $storeUserAction,
        private AccountStoreAction $storeAccountAction
    ) { }

    /**
     * @param StoreDto $dto
     * @return Person
     */
    public function execute(StoreDto $dto, UserStoreDto $storeUserDto): Person
    {
        $person = DB::transaction(function () use (&$dto, &$storeUserDto) {
            $person = $this->createPerson($dto);
            $user = $this->createUser($person, $storeUserDto);
            $this->createAccount($user);

            return $person;
        });

        return $person;
    }

    /**
     * @param StoreDto $dto
     * @return Person
     */
    private function createPerson(StoreDto $dto): Person
    {
        return $this->service->create($dto);
    }
}