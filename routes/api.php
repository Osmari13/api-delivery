<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestaurantOnboardingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    //Crear el tenant y el usuario owner del restaurante
    Route::post(
        '/onboarding/restaurants',
        [RestaurantOnboardingController::class, 'store']
    );
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', fn (Request $request) => $request->user());

});