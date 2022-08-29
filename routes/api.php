<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['as' => 'api.'], function () {
    Route::get('tasks', [TaskController::class, 'index'])->name('tasks.all');
    Route::post('tasks/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::post('tasks/update', [TaskController::class, 'update'])->name('tasks.update');
    Route::post('tasks/destroy', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('tasks/status-update', [TaskController::class, 'status_update'])->name('tasks.status-update');
    Route::post('tasks/priority-update', [TaskController::class, 'priority_update'])->name('tasks.priority-update');
});

