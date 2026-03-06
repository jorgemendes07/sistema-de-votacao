<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;
use App\Http\Controllers\PollOptionController;

// Página inicial
Route::get('/', [PollController::class, 'index'])->name('home');

// Enquetes
Route::resource('polls', PollController::class);

// Opções de enquete 
Route::resource('polls.options', PollOptionController::class);

// Votar
Route::get('polls/{poll}/vote', [PollController::class, 'show'])->name('polls.vote');
Route::post('polls/{poll}/vote', [PollController::class, 'vote'])->name('polls.vote.submit');