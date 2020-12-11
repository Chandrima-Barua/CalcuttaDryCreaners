<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Service;
use App\Invoice;
use App\OrderItem;

class Item extends Model
{
    // 

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }


    //get all orderitems for this item
    public function orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function itemtype()
    {
        return $this->belongsTo(ItemType::class);
    }
}
