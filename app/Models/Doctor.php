<?php

namespace App\Models;

use App\Interfaces\BookableInterface;
use App\Traits\Bookable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $specialization
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Appointment> $appointments
 * @property-read int|null $appointments_count
 * @property-read mixed $service_details
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ScheduleException> $scheduleExceptions
 * @property-read int|null $schedule_exceptions_count
 * @property-read \App\Models\SchedulingSetting|null $schedulingSetting
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkingHour> $workingHours
 * @property-read int|null $working_hours_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereSpecialization($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Doctor extends Model implements BookableInterface
{
    //
    use Bookable;
    protected $guarded = [];

    protected $casts = [
        'details' => 'array',
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function getServiceDetailsAttribute()
    {
        return $this->specialization; // الطبيب يرجع تخصصه
    }
}
