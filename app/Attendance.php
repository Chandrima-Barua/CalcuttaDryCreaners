<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Employee;

class Attendance extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class);
    }

}
