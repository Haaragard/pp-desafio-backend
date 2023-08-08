<?php

namespace App\Repositories;

use App\Models\Person;
use App\Repositories\Contracts\PersonRepositoryContract;

class PersonRepository extends BaseRepository implements PersonRepositoryContract
{
    /**
     * @param Person $model
     */
    public function __construct(Person $model)
    {
        parent::__construct($model);
    }
}