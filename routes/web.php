<?php

use App\Http\Controllers\JoinDemoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [JoinDemoController::class, 'index']);
Route::get('/joins', [JoinDemoController::class, 'index']);
