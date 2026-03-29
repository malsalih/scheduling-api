<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class ProviderSettingsController extends Controller
{
    //
    public function updateWorkingHours(Request $request)
    {

        $request->validate([
            "working_hours" => "required|array",
            "working_hours.*.day_of_week" => "required|integer|min:0|max:6",
            "working_hours.*.start_time" => "nullable|date_format:H:i", // أو H:i:s
            "working_hours.*.end_time" => "nullable|date_format:H:i|after:working_hours.*.start_time",
            "working_hours.*.is_closed" => "required|boolean"
        ]);

        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile)
        {
            return response()->json([
                "success" => false,
                "message" => "قم باكمال الملف الشخصي اولا"
            ], 403);
        }

        // 2. حلقة التحديث الذكية
        foreach ($request->working_hours as $workingHour)
        {
            $profile->workingHours()->updateOrCreate(
                // المصفوفة الأولى: (ابحث عن هذا اليوم تحديداً لهذا المزود)
                [
                    "day_of_week" => $workingHour['day_of_week']
                ],
                // المصفوفة الثانية: (قم بتحديث أو إنشاء هذه البيانات)
                [
                    "start_time" => $workingHour['start_time'],
                    "end_time" => $workingHour['end_time'],
                    "is_closed" => $workingHour['is_closed']
                ]
            );
        }

        return response()->json([
            "success" => true,
            "message" => "تم تحديث أوقات العمل بنجاح."
        ]);
    }

    public function addException(Request $request)
    {
        $request->validate([
            "start_date" => "required|date",
            "end_date" => "required|date|after_or_equal:start_date",
            "reason" => "nullable|string"
        ]);

        $user = Auth::user();

        $profile = $user->profile;

        if (!$profile)
        {
            return response()->json([
                "success" => false,
                "message" => "قم بأكمال ملف المزود اولا",
            ], 403);
        }

        $profile->scheduleExceptions()->create([
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "is_closed" => true,
            "reason" => $request->reason
        ]);

        return response()->json([
            "success" => true,
            "message" => "تم اضافة الاجازة بنجاح"
        ]);
    }
}
