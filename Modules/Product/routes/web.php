<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\client\ProductController;


Route::resource('/', ProductController::class)->names('product')->only('index');

