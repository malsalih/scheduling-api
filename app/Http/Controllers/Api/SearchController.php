<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomService;
use App\Models\Doctor;
use App\Models\Stadium;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function index(Request $request)
    {
        $request->validate([
            "type" => "required|in:doctor,stadium,custom",
            "location" => "nullable|string",
            "keyword" => "nullable|string"
        ]);

        $results = [];

        switch ($request->type)
        {
            case 'doctor':
                $query = Doctor::query();
                $query->when($request->location, fn($q) => $q->where('location', $request->location));
                $query->when($request->keyword, fn($q) => $q->where('name', 'LIKE', '%' . $request->keyword . '%'));
                $results = $query->paginate(10);
                break;

            case 'stadium':
                $query = Stadium::query();
                $query->when($request->location, fn($q) => $q->where('location', $request->location));
                $query->when($request->keyword, fn($q) => $q->where('name', 'LIKE', '%' . $request->keyword . '%'));
                $results = $query->paginate(10);
                break;

            case 'custom':
                $query = CustomService::query();
                $query->when($request->location, fn($q) => $q->where('location', $request->location));
                // في الخدمات المخصصة، قد نبحث في اسم الفئة (category_name) أو النبذة
                $query->when($request->keyword, fn($q) => $q->where('category_name', 'LIKE', '%' . $request->keyword . '%'));
                $results = $query->paginate(10);
                break;
        }
        return response()->json(['success' => true, 'data' => $results]);
    }
}
