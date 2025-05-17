<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\admin\CategoryController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('categories', CategoryController::class)->names('category')->except('show');
});
