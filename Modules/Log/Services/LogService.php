<?php

namespace Modules\Log\Services;

use Modules\Log\Repositories\LogRepository;

class LogService
{
  public function __construct(public LogRepository $repository) {}

  public function paginate(array $filter = [],array $with = [], array $select = ['*'])
  {
    $with = ['causer'];
    return $this->repository->getAllBy($filter,$with, $select);
  }
}
