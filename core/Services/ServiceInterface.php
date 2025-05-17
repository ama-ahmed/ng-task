<?php

namespace core\Services;

use Illuminate\Database\Eloquent\Model;

interface ServiceInterface
{

    public function paginate(array $filter = [], array $with = [], array $select = ['*']);
    public function fetchAll(array $filter = [], array $with = [], array $select = ['*']);

    public function findOrFail(int $id , array $filter = [], array $with = []);

    public function create(array $data);

    public function update(array $data,Model $model);

    public function delete(Model $model);

    public function deleteBulk(array $ids,array $filter);
}
