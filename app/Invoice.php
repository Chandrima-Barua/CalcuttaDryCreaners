<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Service;
use App\Item;
use App\OrderItem;


class Invoice extends Model
{

   public function invoiceable()
    {
        return $this->morphTo();
    }

    public function order()
    {
    	return $this->belongsTo('App\Order');
    }
}


