<?php

namespace Modules\Order\Services;

use core\Services\ServiceAbstract;
use Illuminate\Support\Facades\Session;
use Modules\Order\Repositories\CartRepository;
use Modules\Product\Repositories\ProductRepository;

class CartService extends ServiceAbstract
{
  public function __construct(CartRepository $repository, public ProductRepository $productRepository)
  {
    parent::__construct($repository);
  }

  public function getCart()
  {
    $cart = $this->repository->getCart();
    
    if ($cart) {
      return $cart->load(['items.product.category']);
    }

    return null;
  }

  function addItem(mixed $data)
  {
    $product = $this->productRepository->findOrFail($data['product_id']);
    $cart = $this->repository->getCart();
    
    if (!$cart) {
      $sessionId = Session::getId();
      $cart = $this->repository->create([
        'session_id' => $sessionId,
        'total' => $product->price * $data['quantity']
      ]);
    }

    $cartItem = $this->repository->getItem($cart, $data['product_id']);

    if ($cartItem) {
      $newQuantity = $cartItem->quantity + $data['quantity'];
      $newPrice = $product->price * $newQuantity;

      $this->repository->update($cartItem, [
        'quantity' => $newQuantity,
        'price' => $newPrice
      ]);
    } else {
      $this->repository->createItem($cart, [
        'product_id' => $data['product_id'],
        'quantity' => $data['quantity'],
        'price' => $product->price * $data['quantity']
      ]);
    }

    $this->updateCartTotal($cart);
    return $cart;
  }

  public function updateItemQuantity(mixed $data)
  {
    $cart = $this->repository->getCart();

    if (!$cart) {
      throw new \Exception('Cart not found');
    }

    $cartItem = $cart->items()->findOrFail($data['item_id']);
    $product = $cartItem->product;

    $newQuantity = $cartItem->quantity + $data['change'];

    if ($newQuantity < 1) {
      throw new \Exception('Quantity cannot be less than 1');
    }

    $newPrice = $product->price * $newQuantity;
    $this->repository->update($cartItem, [
      'quantity' => $newQuantity,
      'price' => $newPrice
    ]);

    $this->updateCartTotal($cart);

    return [
      'item' => $cartItem->fresh(),
      'cart' => $cart->fresh()
    ];
  }

  public function removeItem(mixed $data)
  {
    $cart = $this->repository->getCart();

    if (!$cart) {
      throw new \Exception('Cart not found');
    }

    $cartItem = $cart->items()->findOrFail($data['item_id']);
    $this->repository->delete($cartItem);

    $this->updateCartTotal($cart);

    return $cart->fresh();
  }

  public function getCartCount()
  {
    $cart = $this->repository->getCart();

    $count = 0;
    if ($cart) {
      $count = $cart->items()->count();
    }

    return response()->json([
      'status' => true,
      'count' => $count
    ]);
  }

  private function updateCartTotal($cart)
  {
    $total = $cart->items()->sum('price');
    $this->repository->update($cart, [
      'total' => $total
    ]);
    return $cart;
  }
}
