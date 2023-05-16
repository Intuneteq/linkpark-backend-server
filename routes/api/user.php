<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
/*
Group: Groups routes together 
Prefix: Prefix strings to route path
name/as: Gives a name to a router
namespace: helps laravel find controller path
withoutMiddleware: excludes a middleware from a route
*/

Route::group([
    'middleware' => ['auth:api'],
    'as' => 'user.',
    'namespace' => "\App\Http\Controllers"
], function () {
    Route::get('/user', [UserController::class, 'index'])->name('index');
    Route::get('/user/{userId}', [UserController::class, 'show'])->name('show');
});
