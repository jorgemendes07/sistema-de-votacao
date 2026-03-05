<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;
use App\Http\Controllers\PollOptionController;

Route::resource('polls', PollController::class);

// Route::prefix('polls/{poll}')->group(function() {
//     Route::resource('options', PollOptionController::class);
// });

Route::resource('polls.options', PollOptionController::class);