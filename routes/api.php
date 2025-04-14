<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PostController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsNonAdmin;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');
});

Route::prefix('users')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [UserController::class, 'users'])-> middleware(IsAdmin::class);
    Route::post('/', [UserController::class, 'register'])-> middleware(IsAdmin::class);
    Route::patch('/', [UserController::class, 'update'])-> middleware(IsAdmin::class);
    Route::delete('/', [UserController::class, 'delete'])-> middleware(IsAdmin::class);
    Route::delete('/multiple', [UserController::class, 'deleteMultiple'])-> middleware(IsAdmin::class);
    Route::get('/profile', [UserController::class, 'profile']);
});

Route::prefix('posts')->middleware(['auth:sanctum', IsNonAdmin::class])->group(function () {
    Route::get('/', [PostController::class, 'posts']);
    Route::get('/{id}', [PostController::class, 'post']);
    Route::post('/', [PostController::class, 'upload']);
});