<?php

namespace Modules\Order\Http\Controllers\client;

use Illuminate\Http\Request;
use Modules\Order\Http\Requests\CartItemStoreRequest;
use Modules\Order\Http\Requests\CartItemUpdateRequest;
use Modules\Order\Services\CartService;

class CartController
{
    public function __construct(public CartService $service) {}

    public function index()
    {
        $cart = $this->service->getCart();
        return view('order::client.cart', compact('cart'));
    }

    public function addItem(CartItemStoreRequest $request)
    {
        try {
            $cart = $this->service->addItem(collect($request->validated()));

            return response()->json([
                'status' => true,
                'message' => 'Item added to cart successfully',
                'cartCount' => $cart->items()->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function updateQuantity(CartItemUpdateRequest $request)
    {
        try {
            $result = $this->service->updateItemQuantity(collect($request->validated()));

            return response()->json([
                'status' => true,
                'message' => 'Quantity updated successfully',
                'item' => $result['item'],
                'cart' => $result['cart'],
                'cartCount' => $result['cart']->items()->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function removeItem(CartItemUpdateRequest $request)
    {
        try {
            $cart = $this->service->removeItem(collect($request->validated()));

            return response()->json([
                'status' => true,
                'message' => 'Item removed from cart successfully',
                'cart' => $cart,
                'cartCount' => $cart->items()->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function getCartCount()
    {
        return $this->service->getCartCount();
    }
}
