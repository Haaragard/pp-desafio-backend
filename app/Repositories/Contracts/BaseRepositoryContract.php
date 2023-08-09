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

    /**
     * @param string $field
     * @param string $value
     * @param bool $orFail
     * @return Model|null
     * 
     * @throws ModelNotFoundException
     */
    public function findBy(string $field, string $value, bool $orFail = false): ?Model;
}