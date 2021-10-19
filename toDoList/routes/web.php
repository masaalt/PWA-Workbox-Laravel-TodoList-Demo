<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PusherNotificationController;
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
    return view('welcome');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/dashboard',[TaskController::class, 'index'])->name('dashboard');

    Route::get('/task', [TaskController::class, 'add']);
    Route::post('/task', [TaskController::class, 'create']);
    Route::get('/task/{task}', [TaskController::class, 'edit']);
    Route::post('/task/{task}', [TaskController::class, 'update']);
    Route::delete('/task/{task}', [TaskController::class, 'delete']);
    Route::get('/getdata', [TaskController::class, 'getData']);

    Route::get('/notification', function(){
        return view('notification');
    });
    Route::post('send', [PusherNotificationController::class, 'notification']);

   

});
