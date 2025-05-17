<?php

namespace Modules\Order\Http\Controllers\client;

use Modules\Order\Http\Requests\OrderStoreRequest;
use Modules\Order\Services\OrderService;

class OrderController
{
    public function __construct(public OrderService $service) {}

    public function checkout()
    {
        $cart = $this->service->getCart();
        if(!$cart || $cart->total == 0){
            return redirect()->route('product.index');
        }
        return view('order::client.checkout', compact('cart'));
    }

    public function success()
    {
        if (!session()->has('order_completed')) {
            return redirect()->route('product.index');
        }

        $order = session('order_data');
        session()->forget(['order_completed', 'order_data']);
        
        if (!$order) {
            return redirect()->route('product.index');
        }
        
        return view('order::client.success', compact('order'));
    }

    public function store(OrderStoreRequest $request) {
        try {
            $cart = $this->service->getCart();
            if(!$cart || $cart->total == 0){
                return redirect()->route('product.index');
            }

            $data = collect($request->validated())->toArray();
            $data['total'] = $cart->total;
            $order = $this->service->create($data);
            $this->service->storeOrderItems($order, $cart->items->toArray());
            $this->service->clearCart($cart);

            session(['order_completed' => true, 'order_data' => $order]);
            return redirect()->route('order.success');

        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
