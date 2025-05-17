<?php

namespace Modules\Log\Repositories;

use Spatie\Activitylog\Models\Activity;
use core\Infrastructure\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class LogRepository
{
    public function __construct(public Activity $model) {}

    public function getAllBy(array $condition = [],array $with = [], array $select = ['*']): LengthAwarePaginator
    {
        return QueryBuilder::for($this->model::class)
            ->select($select)
            ->orderByDesc('id')
            ->with($with)
            ->where($condition)
            ->paginate(request()->limit ?? 10)
            ->appends(request()->query());
    }
}
