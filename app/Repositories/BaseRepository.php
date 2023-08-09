<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    /**
     * @inheritDoc
     */
    public function findBy(string $field, string $value, bool $orFail = false): ?Model
    {
        $query = $this->model::query()
            ->where($field, $value);

        if ($orFail) {
            return $query->firstOrFail();
        }

        return $query->first();
    }
}