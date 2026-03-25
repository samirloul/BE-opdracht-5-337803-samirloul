<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductLeveringController;

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// User Story 01: Overzicht Geleverde Producten (3 Scenarios)
Route::get('/producten', [ProductLeveringController::class, 'index'])->name('producten.index');
Route::get('/producten/specificatie', [ProductLeveringController::class, 'specification'])->name('producten.specification');
