<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:api', 'isStudent'],
    'as' => 'students.',
    'namespace' => '\App\Http\Controllers'
], function () {
    Route::get('/students/subjects', [StudentController::class, 'getAllSubjects'])->name('getAllSubjects');
});
