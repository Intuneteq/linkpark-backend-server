<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    \App\Helpers\Routes\RouteHelpers::includeRouteFiles(__DIR__ . '/api');
});
