<?php

namespace App\Models;

use App\Interfaces\BookableInterface;
use App\Traits\Bookable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $location
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stadium newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stadium newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stadium query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stadium whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stadium whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stadium whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stadium whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stadium whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Stadium extends Model implements BookableInterface
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
        return $this->location; // الطبيب يرجع تخصصه
    }
}
