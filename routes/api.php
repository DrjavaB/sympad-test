<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return app()->version();
});

Route::get('/index', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'register']);
