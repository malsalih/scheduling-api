<?php

namespace App\Traits;

use App\Models\Appointment;
use App\Models\SchedulingSetting;
use App\Models\WorkingHour;
use App\Models\ScheduleException;

trait Bookable
{
    // 1. المورد (الطبيب مثلاً) لديه "العديد" من المواعيد
    public function appointments()
    {
        return $this->morphMany(Appointment::class, 'bookable');
    }

    // 2. المورد لديه "إعداد واحد" فقط للجدولة (مثلاً: نظام الفترات الثابتة)
    public function schedulingSetting()
    {
        return $this->morphOne(SchedulingSetting::class, 'bookable');
    }

    // 3. المورد لديه "العديد" من أوقات العمل (الأحد، الإثنين، الخ)
    public function workingHours()
    {
        return $this->morphMany(WorkingHour::class, 'bookable');
    }

    // 4. المورد لديه "العديد" من أيام الاستثناءات/الإجازات
    public function scheduleExceptions()
    {
        return $this->morphMany(ScheduleException::class, 'bookable');
    }
}
