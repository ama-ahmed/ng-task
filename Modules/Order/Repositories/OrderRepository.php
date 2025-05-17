<?php

namespace Modules\Order\Repositories;

use core\Infrastructure\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Models\Order;

class OrderRepository extends RepositoriesAbstract
{

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function storeOrderItems(Model $model,array $items){
        $model->orderItems()->createMany($items);
    }


}
