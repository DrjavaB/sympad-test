<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => app()->version());
Route::get('/all-users', [UserController::class, 'allUsers']);
Route::middleware('auth:api')->get('/me', [UserController::class, 'me']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/send-notification/{user}', [NotificationController::class, 'sendNotification']);
