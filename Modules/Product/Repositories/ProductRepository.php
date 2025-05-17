<?php

namespace Modules\Product\Repositories;

use core\Infrastructure\Repositories\Eloquent\RepositoriesAbstract;
use Modules\Product\Models\Product;

class ProductRepository extends RepositoriesAbstract
{

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }


}
