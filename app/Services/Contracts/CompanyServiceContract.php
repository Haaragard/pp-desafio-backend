<?php

namespace App\Services\Contracts;

use App\Dtos\Company\StoreDto;
use App\Models\Company;

interface CompanyServiceContract
{
    /**
     * @param StoreDto $dto
     * @return Company
     */
    public function create(StoreDto $dto): Company;
}