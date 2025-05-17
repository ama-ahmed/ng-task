<?php

namespace core\Infrastructure\Repositories\Eloquent;

use Spatie\QueryBuilder\QueryBuilder;
use core\Infrastructure\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use core\Models\BaseModel;

abstract class RepositoriesAbstract implements RepositoryInterface
{
    protected BaseModel|Builder $model;

    public function __construct(BaseModel $model)
    {
        $this->model = $model;
    }

    public function getTable(): string
    {
        return $this->model->getTable();
    }

    // todo check relation allowed filters
    public function getAllBy(array $condition = [], array $with = [], array $select = ['*']): LengthAwarePaginator
    {
        return QueryBuilder::for($this->model::class)
            ->select($select)
            ->orderByDesc('id')
            ->with($with)
            ->where($condition)
            ->allowedFilters($this->model->getAllowedFilters())
            ->paginate(request()->limit ?? 10)
            ->appends(request()->query());


    }

    public function getAllByQuery(array $condition = [], array $with = [], array $select = ['*'])
    {
        return QueryBuilder::for($this->model::class)
            ->select($select)
            ->orderByDesc('id')
            ->with($with)
            ->where($condition)
            ->allowedFilters($this->model->getAllowedFilters());
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);

    }

    /**
     * {@inheritDoc}
     */
    public function getFirstBy(array $condition = [], array $select = ['*'], array $with = []): Model|null
    {
        return $this->model->with($with)->where($condition)->select($select)->first();

    }

    public function findOrFail(int $id, array $condition = [], array $select = ['*'], array $with = []): Model
    {

        return $this->model->with($with)->select($select)->where($condition)->findOrFail($id);

    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    public function restoreBy(array $condition = []): bool
    {

        $item = $this->model->where($condition)->withTrashed()->first();
        if (!empty($item)) {
            if ($item->restore()) {
                return true;
            }
        }

        return false;
    }

    public function deleteWhereConditions(array $conditions = [])
    {
        return $this->model->where($conditions)->delete();
    }

    public function insert(array $data): bool
    {
        return $this->model->insert($data);
    }

    public function getModel()
    {
        return $this->model;
    }
}
