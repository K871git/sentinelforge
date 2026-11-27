<?php

use App\Http\Controllers\Api\V1\AiAnalysisController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ChecReskController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:register');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/ai-analyses',       [AiAnalysisController::class, 'index']);
    Route::post('/ai-analyses',      [AiAnalysisController::class, 'store']);
    Route::get('/ai-analyses/{id}',  [AiAnalysisController::class, 'show']);
});
