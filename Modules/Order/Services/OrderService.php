<?php

namespace Modules\Order\Services;

use core\Services\ServiceAbstract;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Repositories\CartRepository;
use Modules\Order\Repositories\OrderRepository;


class OrderService extends ServiceAbstract
{
  public function __construct(OrderRepository $repository, public CartRepository $cartRepository)
  {
    parent::__construct($repository);
  }

  public function getCart()
  {
    $cart = $this->cartRepository->getCart();
    return $cart;
  }

  public function storeOrderItems($order, $items)
  {
    $this->repository->storeOrderItems($order, $items);
  }

  public function clearCart(Model $model)
  {
    $this->cartRepository->clearCart($model);
  }
}
