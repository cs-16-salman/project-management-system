<?php

use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\AuthController;


Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
    });

    // Route::apiResource('projects', []);
    // Route::apiResource('tasks', []);
    // Route::apiResource('users', []);

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::apiResource('projects', ProjectController::class);
        Route::apiResource('tasks', TaskController::class);
    });
});
