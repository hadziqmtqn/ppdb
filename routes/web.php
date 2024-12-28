<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::prefix('login')->group(function () {
        Route::get('/', [LoginController::class, 'index'])->name('login');
    });
});