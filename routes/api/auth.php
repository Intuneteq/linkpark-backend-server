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
    'middleware' => ['auth'],
    'as' => 'auth.',
    'namespace' => "\App\Http\Controllers"
], function () {
    Route::get('/auth', [UserController::class, 'index'])->name('index');
    // Route::get('/auth', [UserController::class, 'index'])->name('index')->withoutMiddleware('auth');

    Route::get('/auth/{id}', [UserController::class, 'show'])->name('show')->withoutMiddleware('auth')->where('id', '[0-9]+');

    Route::post('/auth', [UserController::class, 'store'])->name('store');

    Route::patch('/auth/{id}', [UserController::class, 'update'])->name('update');

    Route::delete('/auth/{id}', [UserController::class, 'destroy'])->name('delete');
});
