<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;
use App\Invoice;
use App\OrderItem;

class Service extends Model
{
    protected $fillable = [
        'name',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
    

    public function invoices()
    {
        return $this->morphMany('App\Invoice', 'invoiceable');
    }

    //get all orderitems for this service
    public function orderitems()
    {
        return $this->belongsToMany(OrderItem::class, 'orderitem_service');
    }
}
