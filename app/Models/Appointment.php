<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    // 1. علاقة الموعد بصاحب الحجز (المستخدم)
    // كل موعد يخص مستخدماً واحداً فقط (علاقة 1 إلى متعدد عكسية)
    public function user(){
        return $this->belongsTo(User::class);
    }

    // 2. علاقة الموعد بالشيء المحجوز (طبيب، ملعب، الخ)
    // الدالة morphTo() تخبر لارافيل: "انظر إلى عمودي bookable_type و bookable_id، 
    // واجلب لي الموديل الصحيح بناءً عليهما".
    
    public function bookable(){
        return $this->morphTo();
    }

    
}
