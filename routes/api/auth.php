<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
/*
Group: Groups routes together 
Prefix: Prefix strings to route path
name/as: Gives a name to a router
namespace: helps laravel find controller path
withoutMiddleware: excludes a middleware from a route
*/

Route::group([
    // 'middleware' => ['auth'],
    'as' => 'auth.',
    'namespace' => "\App\Http\Controllers"
], function () {
    Route::post('/auth/register', [AuthController::class, 'register'])->name('register');

    Route::post('/auth/login', [AuthController::class, 'login'])->name('login');

    Route::delete('/auth/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:api');

    Route::get('/auth/refresh', [AuthController::class, 'refresh'])->name('refresh')->middleware('auth:api');

    Route::patch('/auth/change-password', [AuthController::class, 'changePassword'])->name('changePassword');

    Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword')->middleware('auth:api');
});
