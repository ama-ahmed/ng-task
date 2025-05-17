<?php

namespace Modules\Category\Models;

use core\Models\BaseModel;
use Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Category\Database\Factories\CategoryFactory;

class Category extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name'];
    protected $relationsList = ["products"];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
