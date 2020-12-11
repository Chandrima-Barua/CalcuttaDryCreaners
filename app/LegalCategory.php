<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LegalCategory extends Model
{
    public function legals()
    {
        return $this->hasOne(Legal::class);
    }
}
