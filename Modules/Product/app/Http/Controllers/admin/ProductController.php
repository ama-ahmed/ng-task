<?php

namespace Modules\Product\Http\Controllers\admin;


use Modules\Product\Services\ProductService;
use core\Http\Controllers\ControllerAbstract;
use Modules\Category\Services\CategoryService;
use Modules\Product\Http\Requests\ProductStoreRequest;
use Modules\Product\Http\Requests\ProductUpdateRequest;

class ProductController extends ControllerAbstract
{
    protected string $viewsPath = 'product::admin';
    protected string $routeName = "admin.product";
    protected string $storeRequest = ProductStoreRequest::class;
    protected string $updateRequest = ProductUpdateRequest::class;
    protected array $mediaCollections = ['image'];
    protected array $with = ['category'];
    public function __construct(ProductService $service, public CategoryService $categoryService)
    {
        parent::__construct($service);
        $this->append = [
            'categories' => $this->categoryService->fetchAll()
        ];
        
    }
}
