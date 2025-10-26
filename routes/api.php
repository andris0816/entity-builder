<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\WorldController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [SessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
   Route::post('/logout', [SessionController::class, 'destroy']);
   Route::post('/world', [WorldController::class, 'store']);
   Route::get('/world', [WorldController::class, 'indexByUserId']);
   Route::get('/worlds/{world}', [WorldController::class, 'show']);
   Route::post('/entity', [EntityController::class, 'store']);
   Route::post('/relationship', [RelationshipController::class, 'store']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
