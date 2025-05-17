<?php

namespace Modules\Product\Services;

use core\Services\ServiceAbstract;
use Modules\Product\Repositories\ProductRepository;


class ProductService extends ServiceAbstract
{
  public function __construct(ProductRepository $repository)
  {
    parent::__construct($repository);
  }

  
}
