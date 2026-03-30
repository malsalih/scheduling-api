<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {

        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6",
            "role" => "required|in:user,provider",
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);




        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "success" => true,
            "message" => "User created successfully.",
            "token" => $token,
            "user" => [ // أضفنا هذا الجزء
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "role" => $user->getRoleNames()->first(),
            ],
        ], 200);
    }


    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $authorized = Auth::attempt([
            "email" => $request->email,
            "password" => $request->password,
        ]);

        // 1. التعامل مع الفشل أولاً (Early Return)
        if (!$authorized)
        {
            return response()->json([
                'success' => false,
                'message' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.'
            ], 401); // 401 Unauthorized
        }

        // 2. في حالة النجاح (لن يصل الكود إلى هنا إلا إذا كان الدخول صحيحاً)
        /** @var \App\Models\User $user */ // هذا السطر لمساعدة محرر الأكواد فقط
        $user = Auth::user();
        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "success" => true,
            "message" => "تم تسجيل الدخول بنجاح",
            "token" => $token,
            "user" => [ // من الأفضل دائماً إرسال بيانات المستخدم الأساسية للواجهة
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "role" => $user->getRoleNames()->first()
            ]
        ], 200);
    }
}
