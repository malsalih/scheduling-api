<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AvailabilityController;
use App\Http\Controllers\Api\ProviderProfileController;
use App\Http\Controllers\Api\ProviderSettingsController;
use App\Http\Controllers\Api\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request)
{
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/availability', [AvailabilityController::class, 'check']);

Route::post("/register", [AuthController::class, "register"]);

Route::post("/login", [AuthController::class, "login"]);

Route::get("/search", [SearchController::class, "index"]);


Route::middleware(["auth:sanctum"])->group(function ()
{
    Route::post("/provider/setup-profile", [ProviderProfileController::class, "setup"]);
    Route::post("/provider/working-hours", [ProviderSettingsController::class, "updateWorkingHours"]);
    Route::post("/appointment/create", [AppointmentController::class, "store"]);
});
