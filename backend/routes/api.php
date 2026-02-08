<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\OrganizationController;
use App\Http\Controllers\Api\V1\InvitationController;

/*
|--------------------------------------------------------------------------
| Public Health Check (NO auth, NO tenant)
|--------------------------------------------------------------------------
*/

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});


/*
|--------------------------------------------------------------------------
| API v1 Routes
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Public Auth Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
    });

    /*
    |--------------------------------------------------------------------------
    | Protected Auth Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });

    /*
    |--------------------------------------------------------------------------
    | Protected Routes (Require Login)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth:sanctum'])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Project Routes (Require manage_projects permission)
        |--------------------------------------------------------------------------
        */
        Route::get('projects', [ProjectController::class, 'index']); // Members allowed

        Route::post('projects', [ProjectController::class, 'store'])
            ->middleware('permission:manage_projects');

        Route::put('projects/{project}', [ProjectController::class, 'update'])
            ->middleware('permission:manage_projects');

        Route::delete('projects/{project}', [ProjectController::class, 'destroy'])
            ->middleware('permission:manage_projects');

        Route::post('organizations', [OrganizationController::class, 'store']);

        /*
        |--------------------------------------------------------------------------
        | Invitation Routes (Require manage_organization permission)
        |--------------------------------------------------------------------------
        */
        //Admin sends invite (needs org + permission)
        Route::post('invitations', [InvitationController::class, 'store'])
            ->middleware('permission:manage_users');

        // Invited user accepts invite (no org header required)
        Route::post('invitations/accept/{token}', [InvitationController::class, 'accept']);

        /*
        |--------------------------------------------------------------------------
        | Task Routes (Permission-based)
        |--------------------------------------------------------------------------
        */
        Route::post('tasks', [TaskController::class, 'store'])
            ->middleware('permission:create_task');

        Route::put('tasks/{task}', [TaskController::class, 'update'])
            ->middleware('permission:update_task');

        Route::delete('tasks/{task}', [TaskController::class, 'destroy'])
            ->middleware('permission:delete_task');
    });
});
