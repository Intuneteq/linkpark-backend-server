<?php

use App\Mail\GuardianCodeMail;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// It will only run in local env
if (App::environment('local')) {
    Route::get('/playground', function () {
        $user = User::factory()->make();
        Mail::to($user)->send(new GuardianCodeMail($user, 123456));
        return null;
    });
}
