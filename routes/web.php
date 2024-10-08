<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function () {

    $user = \App\Models\User::with(['address', 'info'])->first();
//return $user;
    $service = app(\App\Services\Pagare\PagareAccountService::class);
    return $service->create($user, 'Senha@123');

});
