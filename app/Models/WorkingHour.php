<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    //
    public function bookable(){
        return $this->morphTo();
    }
}
