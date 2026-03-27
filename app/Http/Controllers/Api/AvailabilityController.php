<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    //
    // خريطة لربط الكلمة القادمة من الواجهة بالكلاس الحقيقي (لحماية النظام أمنياً)
    private $modelMap = [
        'doctor' => \App\Models\Doctor::class,
        'stadium' => \App\Models\Stadium::class,
    ];

    public function check(Request $request)
    {

        $request->validate([
            'type' => 'string|required|in:stadium,doctor',
            'id' => 'required|integer',
            'date' => 'required|date'
        ]);

        $modelClass = $this->modelMap[$request->type];
        $bookable = $modelClass::findOrFail($request->id);
        $requestedDate = Carbon::parse($request->date);

        $isHoliday = $bookable->scheduleExceptions()
            ->where('start_date', '<=', $requestedDate->toDateString())
            ->where('end_date', '>=', $requestedDate->toDateString())
            ->where('is_closed', true)
            ->exists();

        if ($isHoliday) {
            return response()->json(['available' => false, 'message' => 'المورد في إجازة في هذا التاريخ.']);
        }

        $dayOfWeek = $requestedDate->dayOfWeek;

        $workingHour = $bookable->workingHours()->where('day_of_week', $dayOfWeek)->first();

        if (!$workingHour || $workingHour->is_closed) {
            return response()->json(['available' => false, 'message' => 'المورد لا يعمل في هذا اليوم.']);
        }


        // 4. جلب إعدادات الجدولة والمواعيد المحجوزة مسبقاً لهذا اليوم
        $setting = $bookable->schedulingSetting;
        $appointments = $bookable->appointments()
            ->whereDate('start_time', $requestedDate->toDateString())
            ->whereIn('status', ['pending', 'confirmed']) // نتجاهل المواعيد الملغاة
            ->get();
    }
}
