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

        if ($isHoliday)
        {
            return response()->json(['available' => false, 'message' => 'المورد في إجازة في هذا التاريخ.']);
        }

        $dayOfWeek = $requestedDate->dayOfWeek;

        $workingHour = $bookable->workingHours()->where('day_of_week', $dayOfWeek)->first();

        if (!$workingHour || $workingHour->is_closed)
        {
            return response()->json(['available' => false, 'message' => 'المورد لا يعمل في هذا اليوم.']);
        }


        // 4. جلب إعدادات الجدولة والمواعيد المحجوزة مسبقاً لهذا اليوم
        $setting = $bookable->schedulingSetting;
        $appointments = $bookable->appointments()
            ->whereDate('start_time', $requestedDate->toDateString())
            ->whereIn('status', ['pending', 'confirmed']) // نتجاهل المواعيد الملغاة
            ->get();


        if ($setting && $setting->scheduling_type === 'open_duration')
        {
            return response()->json([
                'available' => true,
                'type' => 'open_duration',
                'working_hours' => [
                    'start' => $workingHour->start_time,
                    'end' => $workingHour->end_time,
                ],
                'booked_intervals' => $appointments->map(function ($app)
                {
                    return [
                        'start' => Carbon::parse($app->start_time)->format('H:i:s'),
                        'end' => Carbon::parse($app->end_time)->format('H:i:s'),
                    ];
                })
            ]);
        }

        $slotDuration = $setting ? $setting->slot_duration : 30;
        $availableSlots = $this->calculateFixedSlots($workingHour, $appointments, $slotDuration, $requestedDate);

        return response()->json([
            'available' => count($availableSlots) > 0,
            'type' => 'fixed_slots',
            'slots' => $availableSlots
        ]);
    }

    private function calculateFixedSlots($workingHour, $appointments, $slotDuration, $requestedDate)
    {
        $slots = [];
        // دمج التاريخ المطلوب مع وقت بداية ونهاية الدوام
        $startTime = Carbon::parse($requestedDate->toDateString() . ' ' . $workingHour->start_time);
        $endTime = Carbon::parse($requestedDate->toDateString() . ' ' . $workingHour->end_time);

        // حلقة تكرارية لتقسيم وقت الدوام إلى فترات (مثلاً كل 30 دقيقة)
        while ($startTime->copy()->addMinutes($slotDuration)->lte($endTime))
        {
            $slotStart = $startTime->copy();
            $slotEnd = $startTime->copy()->addMinutes($slotDuration);

            // التحقق مما إذا كانت هذه الفترة تتعارض مع أي موعد محجوز
            $isBooked = $appointments->contains(function ($app) use ($slotStart, $slotEnd)
            {
                $appStart = Carbon::parse($app->start_time);
                $appEnd = Carbon::parse($app->end_time);
                // المنطق: هل الفترة الحالية تتقاطع مع الموعد المحجوز؟
                return ($slotStart->lt($appEnd) && $slotEnd->gt($appStart));
            });

            if (!$isBooked)
            {
                $slots[] = [
                    'start' => $slotStart->format('H:i'),
                    'end' => $slotEnd->format('H:i')
                ];
            }

            // الانتقال للفترة التالية
            $startTime->addMinutes($slotDuration);
        }

        return $slots;
    }
}
