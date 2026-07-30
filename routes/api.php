<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PollController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});

Route::get('/polls', [PollController::class, 'index']);
Route::get('/polls/{poll}', [PollController::class, 'show']);
Route::post('/polls/{poll}/vote', [PollController::class, 'vote']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/polls', [PollController::class, 'store']);
    Route::put('/polls/{poll}', [PollController::class, 'update']);
    Route::patch('/polls/{poll}', [PollController::class, 'update']);
    Route::delete('/polls/{poll}', [PollController::class, 'destroy']);
});
