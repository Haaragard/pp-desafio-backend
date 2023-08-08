<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryContract
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes = []): Model;
}