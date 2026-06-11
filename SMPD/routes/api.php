<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;

Route::post('/register', [
    AuthApiController::class,
    'register'
]);

Route::post('/login', [
    AuthApiController::class,
    'login'
]);

Route::post('/logout', [
    AuthApiController::class,
    'logout'
]);