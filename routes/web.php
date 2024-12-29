<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\MenuController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::prefix('login')->group(function () {
        Route::get('/', [LoginController::class, 'index'])->name('login');
        Route::post('/store', [LoginController::class, 'store'])->name('login.store');
    });

    Route::prefix('oauth')->group(function () {
        Route::get('/{provider}', [OAuthController::class, 'redirectToProvider'])->name('oauth.redirect-to-provider');
        Route::get('/{provider}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.handle-callback');
    });
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    });

    Route::prefix('menu')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('menu.index');
        Route::post('/store', [MenuController::class, 'store'])->name('menu.store');
        Route::post('/datatable', [MenuController::class, 'datatable']);
        Route::get('/{menu:slug}', [MenuController::class, 'edit'])->name('menu.edit');
        Route::put('/{menu:slug}/update', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('/{menu:slug}/delete', [MenuController::class, 'destroy']);
    });

    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index');
        Route::post('/datatable', [RoleController::class, 'datatable']);
        Route::get('/{role:slug}', [RoleController::class, 'edit'])->name('role.edit');
        Route::put('/{role:slug}/update', [RoleController::class, 'update'])->name('role.update');
    });

    // TODO Select Routes
    Route::get('select-permission', [PermissionController::class, 'select']);
    Route::get('select-main-menu', [MenuController::class, 'select']);
});