<?php

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
    return view('welcome');
});

Route::post('/api/register', [App\Http\Controllers\UserController::class, 'register'])->name('register');
Route::post('/api/login', [App\Http\Controllers\UserController::class, 'login'])->name('login');
Route::post('/api/web', [App\Http\Controllers\WebController::class, 'store'])->name('store');
