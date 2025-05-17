<?php

namespace Modules\Category\Repositories;

use core\Infrastructure\Repositories\Eloquent\RepositoriesAbstract;
use Modules\Category\Models\Category;

class CategoryRepository extends RepositoriesAbstract
{

    public function __construct(Category $model)
    {
        parent::__construct($model);
    }


}
