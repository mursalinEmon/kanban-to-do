<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('tasks', TaskController::class);
    Route::post('tasks/sync', [TaskController::class, 'sync'])->name('tasks.sync');
    Route::post('tasks/status-update', [TaskController::class, 'status_update'])->name('tasks.status-update');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
