<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Service;
use App\Item;


class OrderItem extends Model
{

    protected $fillable = ['order_id', 'service_id','item_id'];

    // get all services of this orderitem
    public function services()
    {
        return $this->belongsToMany(Service::class, 'orderitem_service');
    }

    // get all items of this orderitem
    public function items()
    {
        return $this->belongTo(Item::class, 'orderitemable');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

}
