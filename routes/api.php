<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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

Route::get('getTasks', [TaskController::class, 'getTasks']);
Route::get('getUsers', [TaskController::class, 'getUsers']);
Route::get('getUserInfo', [TaskController::class, 'getUserInfo']);
Route::get('getUserTasks/{id}', [TaskController::class, 'getUserTasks']);
Route::post('addTask', [TaskController::class, 'addTask']);
Route::post('updateTask/{id}', [TaskController::class, 'updateTask']);
Route::post('deleteTask/{id}', [TaskController::class, 'deleteTask']);