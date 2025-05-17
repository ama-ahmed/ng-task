<?php

namespace Modules\Category\Http\Controllers\admin;

use core\Http\Controllers\ControllerAbstract;
use Modules\Category\Http\Requests\CategoryStoreRequest;
use Modules\Category\Http\Requests\CategoryUpdateRequest;
use Modules\Category\Services\CategoryService;

class CategoryController extends ControllerAbstract
{
    protected string $viewsPath = 'category::admin';
    protected string $routeName = "admin.category";

    protected string $storeRequest = CategoryStoreRequest::class;
    protected string $updateRequest = CategoryUpdateRequest::class;
    public function __construct(CategoryService $service)
    {
        parent::__construct($service);
    }
}
