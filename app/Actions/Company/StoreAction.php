<?php

namespace App\Actions\Company;

use App\Actions\Account\StoreAction as AccountStoreAction;
use App\Actions\Traits\CreateAccountFromUser;
use App\Actions\Traits\CreateUserFromUserable;
use App\Actions\User\StoreAction as UserStoreAction;
use App\Dtos\Company\StoreDto;
use App\Dtos\User\StoreDto as UserStoreDto;
use App\Models\Company;
use App\Services\Contracts\CompanyServiceContract;
use Illuminate\Support\Facades\DB;

class StoreAction
{
    use CreateUserFromUserable;
    use CreateAccountFromUser;

    /**
     * @param CompanyServiceContract $service
     * @param UserStoreAction $storeUserAction
     * @param AccountStoreAction $storeAccountAction
     */
    public function __construct(
        private CompanyServiceContract $service,
        private UserStoreAction $storeUserAction,
        private AccountStoreAction $storeAccountAction
    ) { }

    /**
     * @param StoreDto $dto
     * @return Company
     */
    public function execute(StoreDto $dto, UserStoreDto $storeUserDto): Company
    {
        $company = DB::transaction(function () use (&$dto, &$storeUserDto) {
            $company = $this->createCompany($dto);
            $user = $this->createUser($company, $storeUserDto);
            $this->createAccount($user);

            return $company;
        });

        return $company;
    }

    /**
     * @param StoreDto $dto
     * @return Company
     */
    private function createCompany(StoreDto $dto): Company
    {
        return $this->service->create($dto);
    }
}