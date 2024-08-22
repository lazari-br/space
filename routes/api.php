<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('users', UsersController::class, ['except' => ['destroy']]);
    Route::resource('user-types', UserTypeController::class, ['except' => ['update', 'destroy']]);

    Route::post('personal-data', [UsersController::class, 'getUserData']);
});

Route::middleware('auth:sanctum')->get('test', fn() => 'aooooba');
