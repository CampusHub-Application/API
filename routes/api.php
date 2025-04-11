<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login/user', [AuthController::class, 'login']);

Route::post('/login/admin', [AuthController::class, 'atmin']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/user', [UserController::class, 'update'])->middleware('auth:sanctum');

Route::get('/user', [UserController::class, 'read'])->middleware('auth:sanctum');

Route::delete('/user', [UserController::class, 'delete'])->middleware('auth:sanctum');

Route::patch('/change-password', [UserController::class, 'change'])->middleware('auth:sanctum');
