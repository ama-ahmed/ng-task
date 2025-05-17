<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\client\CartController;
use Modules\Order\Http\Controllers\client\OrderController;

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('orders', OrderController::class)->names('order');
// });


Route::prefix('cart')->name('cart.')->group(function () {
  Route::get('/', [CartController::class, 'index'])->name('index');
  Route::post('/add-item', [CartController::class, 'addItem'])->name('add-item');
  Route::post('/update-quantity', [CartController::class, 'updateQuantity'])->name('update-quantity');
  Route::post('/remove-item', [CartController::class, 'removeItem'])->name('remove-item');
  Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
});

Route::prefix('order')->name('order.')->group(function () {
  Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
  Route::post('/store', [OrderController::class, 'store'])->name('store');
  Route::get('/success', [OrderController::class, 'success'])->name('success');
});
