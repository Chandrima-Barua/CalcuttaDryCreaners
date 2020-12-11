<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'id', 'orderstatus_id',
    ];

    // Belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Has Status
    public function orderstatus()
    {
        return $this->belongsTo(Orderstatus::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function orderitem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
