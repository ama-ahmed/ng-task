<?php

namespace Modules\Order\Models;

use core\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Order\Database\Factories\OrderFactory;

class Order extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['full_name','phone','address','total'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
