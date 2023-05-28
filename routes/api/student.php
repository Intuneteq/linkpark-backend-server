<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'students.',
    'namespace' => '\App\Http\Controllers'
], function () {
    Route::get('/students', [StudentController::class, 'getAllSubjects'])->name('getAllSubjects');
    // Route::get('/students', function () {
    //     return 'data';
    // });

    // Route::get('/student/{student}', [StudentController::class, 'show'])->name('show')->where('student', '[0-9]+');

    // Route::post('/student', [StudentController::class, 'store'])->name('store');

    // Route::patch('/student/{student}', [StudentController::class, 'update'])->name('update')->where('student', '[0-9]+');

    // Route::delete('/student/{student}', [StudentController::class, 'destroy'])->name('delete')->where('student', '[0-9]+');
});
