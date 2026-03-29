<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $bookable_type
 * @property int $bookable_id
 * @property int $day_of_week
 * @property string $start_time
 * @property string $end_time
 * @property bool $is_closed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $bookable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkingHour newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkingHour newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkingHour query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkingHour whereBookableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkingHour whereBookableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkingHour whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkingHour whereDayOfWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkingHour whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkingHour whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkingHour whereIsClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkingHour whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkingHour whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WorkingHour extends Model
{
    //
    protected $fillable = [
        "day_of_week",
        "is_closed",
        "start_time",
        "end_time"
    ];

    public function bookable()
    {
        return $this->morphTo();
    }
}
