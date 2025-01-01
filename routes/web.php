<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Dashboard\AccountController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\EmailChangeController;
use App\Http\Controllers\Dashboard\References\EducationalInstitutionController;
use App\Http\Controllers\Dashboard\References\EducationalLevelController;
use App\Http\Controllers\Dashboard\References\RegistrationScheduleController;
use App\Http\Controllers\Dashboard\References\SchoolYearController;
use App\Http\Controllers\Dashboard\Setting\ApplicationController;
use App\Http\Controllers\Dashboard\Setting\EmailConfigController;
use App\Http\Controllers\Dashboard\Setting\MenuController;
use App\Http\Controllers\Dashboard\Setting\MessageTemplateController;
use App\Http\Controllers\Dashboard\Setting\PermissionController;
use App\Http\Controllers\Dashboard\Setting\RoleController;
use App\Http\Controllers\Dashboard\Setting\WhatsappConfigController;
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

    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('account.index');
        Route::post('/update', [AccountController::class, 'update'])->name('account.update');
    });

    Route::prefix('menu')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('menu.index');
        Route::post('/store', [MenuController::class, 'store'])->name('menu.store');
        Route::post('/datatable', [MenuController::class, 'datatable']);
        Route::get('/{menu:slug}', [MenuController::class, 'edit'])->name('menu.edit');
        Route::put('/{menu:slug}/update', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('/{menu:slug}/delete', [MenuController::class, 'destroy']);
    });

    Route::get('search-menu', [MenuController::class, 'searchMenu']);

    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index');
        Route::post('/datatable', [RoleController::class, 'datatable']);
        Route::get('/{role:slug}', [RoleController::class, 'edit'])->name('role.edit');
        Route::put('/{role:slug}/update', [RoleController::class, 'update'])->name('role.update');
    });

    Route::prefix('application')->group(function () {
        Route::get('/', [ApplicationController::class, 'index'])->name('application.index');
        Route::post('/', [ApplicationController::class, 'store'])->name('application.store');
    });

    Route::prefix('educational-level')->group(function () {
        Route::get('/', [EducationalLevelController::class, 'index'])->name('educational-level.index');
        Route::post('/datatable', [EducationalLevelController::class, 'datatable']);
        Route::put('/{educationalLevel:slug}/store', [EducationalLevelController::class, 'store']);
    });

    Route::prefix('educational-institution')->group(function () {
        Route::get('/', [EducationalInstitutionController::class, 'index'])->name('educational-institution.index');
        Route::post('/datatable', [EducationalInstitutionController::class, 'datatable']);
        Route::post('/store', [EducationalInstitutionController::class, 'store'])->name('educational-institution.store');
        Route::get('/{educationalInstitution:slug}', [EducationalInstitutionController::class, 'show'])->name('educational-institution.show');
        Route::put('/{educationalInstitution:slug}/update', [EducationalInstitutionController::class, 'update'])->name('educational-institution.update');
    });

    Route::prefix('whatsapp-config')->group(function () {
        Route::get('/', [WhatsAppConfigController::class, 'index'])->name('whatsapp-config.index');
        Route::post('/store', [WhatsAppConfigController::class, 'store'])->name('whatsapp-config.store');
    });

    Route::prefix('email-config')->group(function () {
        Route::get('/', [EmailConfigController::class, 'index'])->name('email-config.index');
        Route::post('/store', [EmailConfigController::class, 'store'])->name('email-config.store');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::post('/datatable', [AdminController::class, 'datatable']);
        Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/{user:username}', [AdminController::class, 'show'])->name('admin.show');
        Route::put('/{user:username}/update', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/{user:username}/delete', [AdminController::class, 'destroy']);
        Route::post('/{user:username}/restore', [AdminController::class, 'restore']);
        Route::delete('/{user:username}/force-delete', [AdminController::class, 'forceDelete']);
    });

    Route::prefix('message-template')->group(function () {
        Route::get('/', [MessageTemplateController::class, 'index'])->name('message-template.index');
        Route::post('/store', [MessageTemplateController::class, 'store'])->name('message-template.store');
        Route::post('/datatable', [MessageTemplateController::class, 'datatable']);
        Route::get('/{messageTemplate:slug}', [MessageTemplateController::class, 'show'])->name('message-template.show');
        Route::put('/{messageTemplate:slug}/update', [MessageTemplateController::class, 'update'])->name('message-template.update');
        Route::delete('/{messageTemplate:slug}/delete', [MessageTemplateController::class, 'destroy']);
    });

    Route::get('email-verification', [EmailChangeController::class, 'verification'])->name('email-change.verification');

    Route::prefix('school-year')->group(function () {
        Route::get('/', [SchoolYearController::class, 'index'])->name('school-year.index');
        Route::post('/datatable', [SchoolYearController::class, 'datatable']);
        Route::post('/store', [SchoolYearController::class, 'store'])->name('school-year.store');
        Route::get('/{schoolYear:slug}', [SchoolYearController::class, 'show'])->name('school-year.show');
        Route::put('/{schoolYear:slug}/update', [SchoolYearController::class, 'update'])->name('school-year.update');
    });

    Route::prefix('registration-schedule')->group(function () {
        Route::post('/datatable', [RegistrationScheduleController::class, 'datatable']);
        Route::post('/store', [RegistrationScheduleController::class, 'store']);
        Route::put('/{registrationSchedule:slug}/update', [RegistrationScheduleController::class, 'update']);
    });

    // TODO Select Routes
    Route::get('select-permission', [PermissionController::class, 'select']);
    Route::get('select-main-menu', [MenuController::class, 'select']);
    Route::get('select-educational-level', [EducationalLevelController::class, 'select']);
    Route::get('select-role', [RoleController::class, 'select']);
    Route::get('select-educational-institution', [EducationalInstitutionController::class, 'select']);
    Route::get('select-school-year', [SchoolYearController::class, 'select']);
});