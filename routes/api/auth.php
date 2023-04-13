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

    // Route::get('/auth/{id}', [AuthController::class, 'show'])->name('show')->withoutMiddleware('auth')->where('id', '[0-9]+');

    // Route::post('/auth', [AuthController::class, 'store'])->name('store');

    // Route::patch('/auth/{id}', [AuthController::class, 'update'])->name('update');

    // Route::delete('/auth/{id}', [AuthController::class, 'destroy'])->name('delete');
});
