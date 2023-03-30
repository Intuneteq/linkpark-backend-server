<?php

use App\Http\Controllers\SchoolController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'school.',
    'namespace' => '\App\Http\Controllers'
], function () {
    Route::get('/school', [SchoolController::class, 'index'])->name('index');

    Route::get('/school/{school}', [SchoolController::class, 'show'])->name('show')->where('school', '[0-9]+');

    Route::post('/school', [SchoolController::class, 'store'])->name('store');

    Route::patch('/school/{school}', [SchoolController::class, 'update'])->name('update')->where('school', '[0-9]+');

    Route::delete('/school/{school}', [SchoolController::class, 'destroy'])->name('delete')->where('school', '[0-9]+');
});
