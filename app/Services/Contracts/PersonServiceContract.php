<?php

namespace App\Services\Contracts;

use App\Dtos\Person\StoreDto;
use App\Models\Person;

interface PersonServiceContract
{
    /**
     * @param StoreDto $dto
     * @return Person
     */
    public function create(StoreDto $dto): Person;
}