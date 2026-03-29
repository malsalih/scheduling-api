<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $bookable_type
 * @property int $bookable_id
 * @property string $start_time
 * @property string $end_time
 * @property string $status
 * @property numeric $total_price
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $bookable
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereBookableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereBookableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereUserId($value)
 * @mixin \Eloquent
 */
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
