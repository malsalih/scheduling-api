<?php

namespace App\Models;

use App\Traits\Bookable;
use Illuminate\Database\Eloquent\Model;

class CustomService extends Model
{
    //
    use Bookable;

    protected $casts = [
        'details' => 'array',
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function getServiceDetailsAttribute()
    {
        return $this->category_name; // أو يمكنك إرجاع قيمة معينة من حقل الـ JSON
    }
}
