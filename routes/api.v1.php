<?php

use App\Http\Controllers\Api\v1\{Auth\AuthController, Task\TaskController};
use Illuminate\Support\Facades\Route;

/*
|
|--------------------------------------------------------------------------
| auth routes
|--------------------------------------------------------------------------
|
*/
Route::controller(AuthController::class)->name('auth.')->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register')->name('register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', 'me')->name('me');
        Route::get('logout', 'logout')->name('logout');
    });
});

/*
|
|--------------------------------------------------------------------------
| task routes
|--------------------------------------------------------------------------
|
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('task/{id}/mark-as-complete', [TaskController::class, 'markAsComplete'])->name('task.mark-as-complete');
    Route::apiResource('task', TaskController::class);
});
