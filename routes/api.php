<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

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


Route::get(
    '/csrf-cookie',
    CsrfCookieController::class . '@show'
)->middleware('web')->name('auth.cookies');


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('user', UserController::class)->only('index', 'store', 'update', 'destroy');

    Route::resource('task', TaskController::class);

    Route::resource('satuan', SatuanController::class);
    Route::post('logout', AuthController::class . '@logout')->name('auth.logout');
    Route::get('me', AuthController::class . '@me')->name('auth.me');
});
Route::post('login', AuthController::class . '@login')->name('auth.login');
