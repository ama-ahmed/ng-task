<?php

namespace Modules\Order\Http\Controllers\admin;


use core\Http\Controllers\ControllerAbstract;
use Modules\Order\Http\Requests\OrderStoreRequest;
use Modules\Order\Services\OrderService;

class OrderController extends ControllerAbstract
{
    protected string $viewsPath = 'order::admin';
    protected string $routeName = "admin.order";
    protected array $with = ['orderItems'];
    // protected string $storeRequest = OrderStoreRequest::class;
    // protected array $mediaCollections = ['image'];
    public function __construct(OrderService $service)
    {
        parent::__construct($service);
    }
}
