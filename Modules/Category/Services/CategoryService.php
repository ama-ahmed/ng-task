<?php

namespace Modules\Category\Services;

use core\Services\ServiceAbstract;
use Modules\Category\Repositories\CategoryRepository;

class CategoryService extends ServiceAbstract
{
  public function __construct(CategoryRepository $repository)
  {
    parent::__construct($repository);
  }
  
}
