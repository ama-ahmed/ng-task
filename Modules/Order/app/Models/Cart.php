<?php

namespace Modules\Order\Models;

use core\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Order\Database\Factories\CartFactory;

class Cart extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['session_id', 'total'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
