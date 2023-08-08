<?php

namespace App\Services;

use App\Repositories\Contracts\PersonRepositoryContract;
use App\Services\Contracts\PersonServiceContract;

class PersonService implements PersonServiceContract
{
    /**
     * @param PersonRepositoryContract $repository
     */
    public function __construct(private PersonRepositoryContract $repository)
    { }
}