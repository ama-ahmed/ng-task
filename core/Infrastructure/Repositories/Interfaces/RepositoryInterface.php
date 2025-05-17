<?php

namespace core\Infrastructure\Repositories\Interfaces;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    /**
     * Get table name.
     */
    public function getTable(): string;

    public function getFirstBy(array $condition = [], array $select = [], array $with = []): Model|NULL;

    /**
     * Get all models by key/value.
     */
    public function getAllBy(array $condition, array $with = [], array $select = ['*']): LengthAwarePaginator;
    public function getAllByQuery(array $condition=[], array $with = [], array $select = ['*']);

    public function create(array $data): Model;

    /**
     * Delete model.
     *
     * @throws Exception
     */
    public function delete(Model $model): bool;

    public function update(Model $model , array $data): bool;

    /**
     * @return mixed
     */
    public function restoreBy(array $condition = []): bool;

    public function insert(array $data): bool;

    public function getModel();
}
