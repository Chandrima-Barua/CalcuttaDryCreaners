<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'branch_user');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
