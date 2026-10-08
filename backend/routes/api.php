<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/check', function () {
    return response()->json([
        "status" => true,
        "message" => "Backend is running successfully",
    ], 200);
});

Route::post('/register', [AuthController::class, 'register']);
