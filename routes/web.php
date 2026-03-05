<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/debug-tables', function () {
    $tables = DB::select('SHOW TABLES');
    dd($tables);
});