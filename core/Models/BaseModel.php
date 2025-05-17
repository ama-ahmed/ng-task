<?php

namespace core\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

abstract class BaseModel extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected array $allowedFilters=['id','name'];

    public function getAllowedFilters(){
        return $this->allowedFilters ;
    }
}
