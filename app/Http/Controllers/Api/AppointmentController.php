<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    //
    private $modelMap = [
        'doctor' => \App\Models\Doctor::class,
        'stadium' => \App\Models\Stadium::class,
        'custom' => \App\Models\CustomService::class
    ];

    public function store(Request $request)
    {
        $request->validate([
            "provider_type" => "required|in:doctor,stadium,custom",
            "provider_id" => "required|integer",
            "start_time" => "required|date_format:Y-m-d H:i", // تأكيد استلام التاريخ والوقت معاً
            "end_time" => "required|date_format:Y-m-d H:i|after:start_time",
        ]);

        $modelClass = $this->modelMap[$request->provider_type];

        $user = Auth::user();

        $bookable = $modelClass::findOrFail($request->provider_id);

        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);

        $isOverlapping = $bookable->appointments()->whereIn("status", ["pending", "confirmed"])->where(function ($q) use ($start, $end)
        {
            $q->where('start_time', '<', $end)
                ->where('end_time', '>', $start);
        })->exists();
        if ($isOverlapping)
        {
            return response()->json([
                'success' => false,
                'message' => 'عذراً، هذا الوقت محجوز مسبقاً.'
            ], 400);
        }
        $appointment = $bookable->appointments()->create([
            'user_id' => $user->id,
            'start_time' => $start->format('Y-m-d H:i'),
            'end_time' => $end->format('Y-m-d H:i'),
            'status' => 'pending', // نجعله قيد الانتظار كإجراء قياسي
            'total_price' => 150.00, // مؤقتاً حتى نبرمج التسعير الديناميكي
        ]);

        // 4. الاستجابة
        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الموعد بنجاح.',
            'data' => $appointment
        ], 201);
    }
}
