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
            "specific_detail" => "string",
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

        switch ($request->service_type)
        {
            case 'doctor':
                $newService = Doctor::create([
                    "name" => $request->name,
                    "specialization" => $request->specific_detail,
                ]);
                # code...
                break;
            case 'stadium':
                $newService = Stadium::create([
                    "name" => $request->name,
                    "location" => $request->specific_detail,
                ]);
                # code...
                break;
            case 'custom':
                $newService = CustomService::create([
                    "name" => $request->name,
                    "category_name" => $request->specific_detail,
                ]);
                # code...
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
                "details" => $newService->service_details,

            ]
        ]);
    }
}
