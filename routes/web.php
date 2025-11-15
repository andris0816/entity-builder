<?php

use Illuminate\Support\Facades\Route;
Route::get('/debug-app-url', function () {
    return config('app.url');
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');

Route::get('/', function () {
    return view('app');
});
