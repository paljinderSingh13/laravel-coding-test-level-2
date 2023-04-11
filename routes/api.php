<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    Route::controller(UserController::class)->middleware('checkRole:ADMIN')->group(function () {
        Route::get('/users/{role}', 'index');
        Route::get('/users/{user_id}/{role}', 'show');
        Route::put('/users/{user_id}/{role}', 'idempotent_update');
        Route::patch('/users/{user_id}/{role}', 'update');
        Route::delete('/users/{user_id}/{role}', 'destroy');
        Route::post('/users/{role}', 'store');
    });
    Route::middleware('checkRole:PRODUCT_OWNER')->group(function () {
        Route::controller(ProjectController::class)->group(function () {
            Route::get('/project/{role}', 'index');
            Route::get('/project/{project_id}/{role}', 'show');
            Route::put('/project/{project_id}/{role}', 'idempotent_update');
            Route::patch('/project/{project_id}/{role}', 'update');
            Route::delete('/project/{project_id}/{role}', 'destroy');
            Route::post('/project/{role}', 'store');
            Route::post('/project-assign-users/{role}', 'assign_user');
        });

        Route::controller(TaskController::class)->group(function () {
            Route::get('/tasks/{role}', 'index');
            Route::get('/task/{task_id}/{role}', 'show');
            Route::patch('/task/{task_id}/{role}', 'update');
            Route::delete('/task/{task_id}/{role}', 'destroy');
            Route::post('/task/{role}', 'store');
        });
    });
    //Route::get('/users/{user}', [UserController::class, 'show']);
        Route::put('/task-status-change/{task_id}/{role}', [TaskController::class,'idempotent_update'])->middleware('checkRole:TEAM_MEMBER');

});
