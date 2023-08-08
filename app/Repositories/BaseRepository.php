<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryContract;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryContract
{
    /**
     * @param Model $model
     */
    public function __construct(protected Model $model)
    { }

    /**
     * @inheritDoc
     */
    public function create(array $attributes = []): Model
    {
        return $this->model::create($attributes);
    }
}