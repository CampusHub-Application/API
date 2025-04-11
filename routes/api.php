<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsNonAdmin;


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');
});

Route::prefix('profile')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [ProfileController::class, 'profile']);
    Route::patch('/', [ProfileController::class, 'update']);
});

Route::prefix('users')->middleware(['auth:sanctum', IsAdmin::class])->group(function () {
    Route::get('/', [UserController::class, 'users']);
    Route::post('/', [UserController::class, 'register']);
    Route::patch('/', [UserController::class, 'update']);
    Route::delete('/', [UserController::class, 'delete']);
});

Route::prefix('posts')->middleware(['auth:sanctum', IsNonAdmin::class])->group(function () {
    Route::get('/', [PostController::class, 'posts']);
    Route::get('/{id}', [PostController::class, 'post']);
    Route::post('/', [PostController::class, 'create']);
});