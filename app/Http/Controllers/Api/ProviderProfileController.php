<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomService;
use App\Models\Doctor;
use App\Models\Stadium;
use Auth;
use Illuminate\Http\Request;

class ProviderProfileController extends Controller
{
    //

    private $modelMap = [
        'doctor' => \App\Models\Doctor::class,
        'stadium' => \App\Models\Stadium::class,
        'custom' => \App\Models\CustomService::class,

    ];

    public function setup(Request $request)
    {
        $request->validate([
            "service_type" => "required|in:stadium,doctor,custom",
            "name" => "required|string",
            "location" => "nullable|string", // الحقل الجديد
            "bio" => "nullable|string",      // الحقل الجديد
            "specific_detail" => "nullable|string", // (تخصص الطبيب أو فئة الخدمة المخصصة)
            "details" => "nullable|array",
        ]);

        $user = Auth::user();

        if ($user->profile)
        {
            return response()->json([
                "success" => false,
                "message" => "هذا الحساب يمتلك ملف خدمة مسبقاً."
            ], 400); // 400 Bad Request
        }

        $newService = null;

        $commonData = [
            "name" => $request->name,
            "location" => $request->location,
            "bio" => $request->bio,
            "details" => $request->details ?? [], // إذا لم يرسل تفاصيل، نضع مصفوفة فارغة
        ];

        switch ($request->service_type)
        {
            case 'doctor':
                $newService = Doctor::create(array_merge($commonData, [
                    "specialization" => $request->specific_detail,
                ]));
                break;
            case 'stadium':
                $newService = Stadium::create(array_merge($commonData, [
                    // location موجود مسبقاً في commonData
                ]));
                break;

            case 'custom':
                $newService = CustomService::create(array_merge($commonData, [
                    "category_name" => $request->specific_detail,
                ]));
                break;

            default:
                return response()->json([
                    "success" => false,
                    "message" => "Wrong service type"
                ], 422);
                # code...
                break;
        }
        $user->profile()->associate($newService);
        $user->save();

        return response()->json([
            "success" => true,
            "message" => "تم إعداد ملف الخدمة بنجاح",
            "service" => [
                "name" => $newService->name,
                "type" => $request->service_type,
                "details" => $newService->service_details,
            ]
        ]);
    }
}
