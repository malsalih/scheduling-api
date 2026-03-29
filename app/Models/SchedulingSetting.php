<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $bookable_type
 * @property int $bookable_id
 * @property string $scheduling_type
 * @property int $slot_duration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchedulingSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchedulingSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchedulingSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchedulingSetting whereBookableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchedulingSetting whereBookableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchedulingSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchedulingSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchedulingSetting whereSchedulingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchedulingSetting whereSlotDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SchedulingSetting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SchedulingSetting extends Model
{
    //
}
