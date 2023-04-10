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
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index');
        Route::get('/users/{user_id}', 'show');
        Route::put('/users/{user_id}', 'idempotent_update');
        Route::patch('/users/{user_id}', 'update');
        Route::delete('/users/{user_id}', 'destroy');
        Route::post('/users', 'store');
    });
    Route::controller(ProjectController::class)->group(function () {
        Route::get('/project', 'index');
        Route::get('/project/{project_id}', 'show');
        Route::put('/project/{project_id}', 'idempotent_update');
        Route::patch('/project/{project_id}', 'update');
        Route::delete('/project/{project_id}', 'destroy');
        Route::post('/project', 'store');
        Route::post('/project-assign-users', 'assign_user');
    });
    Route::controller(TaskController::class)->group(function () {
        Route::get('/tasks', 'index');
        Route::get('/task/{task_id}', 'show');
        Route::put('/task-status-change/{task_id}', 'idempotent_update');
        Route::patch('/task/{task_id}', 'update');
        Route::delete('/task/{task_id}', 'destroy');
        Route::post('/task', 'store');
    });

});
