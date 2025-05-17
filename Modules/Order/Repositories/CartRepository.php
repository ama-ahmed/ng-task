<?php

namespace Modules\Order\Repositories;

use Modules\Order\Models\Cart;
use Modules\Order\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use core\Infrastructure\Repositories\Eloquent\RepositoriesAbstract;

class CartRepository extends RepositoriesAbstract
{

    public function __construct(Cart $model)
    {
        parent::__construct($model);
    }

    public function getItem(Model $model, int $id){
        return $model->items()->where('product_id', $id)->first();
    }

    public function createItem(Model $model, array $data){
        return $model->items()->create($data);
    }

    public function getCart()
    {
      $sessionId = Session::getId();
      $cart = $this->getFirstBy(['session_id' => $sessionId]);
  
      if ($cart) {
        return $cart;
      }
  
      return null;
    }

    public function clearCart(Model $model){
        $model->items()->delete();
        $model->delete();
    }
}
