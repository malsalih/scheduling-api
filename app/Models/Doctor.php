<?php

namespace App\Models;

use App\Interfaces\BookableInterface;
use App\Traits\Bookable;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model implements BookableInterface
{
    //
    use Bookable;
    protected $guarded = [];

    public function getServiceDetailsAttribute()
    {
        return $this->specialization; // الطبيب يرجع تخصصه
    }
}
