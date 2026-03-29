<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $bookable_type
 * @property int $bookable_id
 * @property string $start_date
 * @property string $end_date
 * @property bool $is_closed
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScheduleException newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScheduleException newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScheduleException query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScheduleException whereBookableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScheduleException whereBookableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScheduleException whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScheduleException whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScheduleException whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScheduleException whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScheduleException whereIsClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScheduleException whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScheduleException whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScheduleException whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScheduleException whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ScheduleException extends Model
{
    //
}
