<?php

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

Route::post('/login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\Api\Auth\AuthController::class, 'register']);
Route::post('/forgotPassword', [\App\Http\Controllers\Api\Auth\AuthController::class, 'forgotPassword']);

Route::post('/logout', [\App\Http\Controllers\Api\Auth\AuthController::class, 'logout'])
    ->middleware('auth:api');
Route::post('/updateAccount', [\App\Http\Controllers\Api\Auth\AuthController::class, 'updateAccount'])
    ->middleware('auth:api');
