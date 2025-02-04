<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\PasswordValidationController;
use App\Http\Controllers\Dashboard\AccountController;
use App\Http\Controllers\Dashboard\AccountVerificationController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\EmailChangeController;
use App\Http\Controllers\Dashboard\References\ClassLevelController;
use App\Http\Controllers\Dashboard\References\DetailMediaFileController;
use App\Http\Controllers\Dashboard\References\DistanceToSchoolController;
use App\Http\Controllers\Dashboard\References\EducationalInstitutionController;
use App\Http\Controllers\Dashboard\References\EducationalLevelController;
use App\Http\Controllers\Dashboard\References\EducationController;
use App\Http\Controllers\Dashboard\References\IncomeController;
use App\Http\Controllers\Dashboard\References\MajorController;
use App\Http\Controllers\Dashboard\References\MediaFileController;
use App\Http\Controllers\Dashboard\References\ProfessionController;
use App\Http\Controllers\Dashboard\References\RegistrationCategoryController;
use App\Http\Controllers\Dashboard\References\RegistrationPathController;
use App\Http\Controllers\Dashboard\References\RegistrationScheduleController;
use App\Http\Controllers\Dashboard\References\SchoolYearController;
use App\Http\Controllers\Dashboard\References\TransportationController;
use App\Http\Controllers\Dashboard\Setting\ApplicationController;
use App\Http\Controllers\Dashboard\Setting\EmailConfigController;
use App\Http\Controllers\Dashboard\Setting\MenuController;
use App\Http\Controllers\Dashboard\Setting\MessageReceiverController;
use App\Http\Controllers\Dashboard\Setting\MessageTemplateController;
use App\Http\Controllers\Dashboard\Setting\PermissionController;
use App\Http\Controllers\Dashboard\Setting\RoleController;
use App\Http\Controllers\Dashboard\Setting\WhatsappConfigController;
use App\Http\Controllers\Dashboard\Student\AcceptanceRegistrationController;
use App\Http\Controllers\Dashboard\Student\FamilyController;
use App\Http\Controllers\Dashboard\Student\FileUploadingController;
use App\Http\Controllers\Dashboard\Student\PersonalDataController;
use App\Http\Controllers\Dashboard\Student\PreviousSchoolController;
use App\Http\Controllers\Dashboard\Student\ResidenceController;
use App\Http\Controllers\Dashboard\Student\StudentController;
use App\Http\Controllers\Dashboard\Student\StudentRegistrationController;
use App\Http\Controllers\Dashboard\Student\StudentReportController;
use App\Http\Controllers\Dashboard\Student\StudentSecurityController;
use App\Http\Controllers\Dashboard\Student\StudentStatsController;
use App\Http\Controllers\Dashboard\Student\ValidationController;
use App\Http\Controllers\Home\RegistrationController;
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

    Route::prefix('register')->group(function () {
        Route::get('/', [RegistrationController::class, 'index'])->name('registration.index');
        Route::post('/store', [RegistrationController::class, 'store']);
    });
});

Route::middleware('auth')->group(function () {
    Route::middleware('account_verified')->group(function () {
        // TODO Auth
        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
        Route::post('password-validation', [PasswordValidationController::class, 'store']);

        // TODO Dashboard
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
            Route::post('/datatable', [WhatsAppConfigController::class, 'datatable']);
            Route::put('/{whatsappConfig:slug}/update', [WhatsAppConfigController::class, 'update']);
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

        Route::prefix('registration-category')->group(function () {
            Route::get('/', [RegistrationCategoryController::class, 'index'])->name('registration-category.index');
            Route::post('/datatable', [RegistrationCategoryController::class, 'datatable']);
            Route::post('/store', [RegistrationCategoryController::class, 'store'])->name('registration-category.store');
            Route::put('/{registrationCategory:slug}/update', [RegistrationCategoryController::class, 'update']);
            Route::delete('/{registrationCategory:slug}/delete', [RegistrationCategoryController::class, 'destroy']);
        });

        Route::prefix('class-level')->group(function () {
            Route::get('/', [ClassLevelController::class, 'index'])->name('class-level.index');
            Route::post('/datatable', [ClassLevelController::class, 'datatable']);
            Route::post('/store', [ClassLevelController::class, 'store']);
            Route::put('/{classLevel:slug}/update', [ClassLevelController::class, 'update']);
            Route::delete('/{classLevel:slug}/delete', [ClassLevelController::class, 'destroy']);
        });

        Route::prefix('registration-path')->group(function () {
            Route::get('/', [RegistrationPathController::class, 'index'])->name('registration-path.index');
            Route::post('/datatable', [RegistrationPathController::class, 'datatable']);
            Route::post('/store', [RegistrationPathController::class, 'store']);
            Route::put('/{registrationPath:slug}/update', [RegistrationPathController::class, 'update']);
            Route::delete('/{registrationPath:slug}/delete', [RegistrationPathController::class, 'destroy']);
        });

        Route::prefix('major')->group(function () {
            Route::get('/', [MajorController::class, 'index'])->name('major.index');
            Route::post('/datatable', [MajorController::class, 'datatable']);
            Route::post('/store', [MajorController::class, 'store']);
            Route::put('/{major:slug}/update', [MajorController::class, 'update']);
            Route::delete('/{major:slug}/delete', [MajorController::class, 'destroy']);
        });

        Route::prefix('distance-to-school')->group(function () {
            Route::get('/', [DistanceToSchoolController::class, 'index'])->name('distance-to-school.index');
            Route::post('/datatable', [DistanceToSchoolController::class, 'datatable']);
            Route::post('/store', [DistanceToSchoolController::class, 'store']);
            Route::put('/{distanceToSchool:slug}/update', [DistanceToSchoolController::class, 'update']);
            Route::delete('/{distanceToSchool:slug}/delete', [DistanceToSchoolController::class, 'destroy']);
        });

        Route::prefix('transportation')->group(function () {
            Route::get('/', [TransportationController::class, 'index'])->name('transportation.index');
            Route::post('/datatable', [TransportationController::class, 'datatable']);
            Route::post('/store', [TransportationController::class, 'store']);
            Route::put('/{transportation:slug}/update', [TransportationController::class, 'update']);
            Route::delete('/{transportation:slug}/delete', [TransportationController::class, 'destroy']);
        });

        Route::prefix('profession')->group(function () {
            Route::get('/', [ProfessionController::class, 'index'])->name('profession.index');
            Route::post('/datatable', [ProfessionController::class, 'datatable']);
            Route::post('/store', [ProfessionController::class, 'store']);
            Route::put('/{profession:slug}/update', [ProfessionController::class, 'update']);
            Route::delete('/{profession:slug}/delete', [ProfessionController::class, 'destroy']);
        });

        Route::prefix('education')->group(function () {
            Route::get('/', [EducationController::class, 'index'])->name('education.index');
            Route::post('/datatable', [EducationController::class, 'datatable']);
            Route::post('/store', [EducationController::class, 'store']);
            Route::put('/{education:slug}/update', [EducationController::class, 'update']);
            Route::delete('/{education:slug}/delete', [EducationController::class, 'destroy']);
        });

        Route::prefix('income')->group(function () {
            Route::get('/', [IncomeController::class, 'index'])->name('income.index');
            Route::post('/datatable', [IncomeController::class, 'datatable']);
            Route::post('/store', [IncomeController::class, 'store']);
            Route::put('/{income:slug}/update', [IncomeController::class, 'update']);
            Route::delete('/{income:slug}/delete', [IncomeController::class, 'destroy']);
        });

        Route::prefix('message-receiver')->group(function () {
            Route::post('/store', [MessageReceiverController::class, 'store']);
            Route::post('/datatable', [MessageReceiverController::class, 'datatable']);
            Route::delete('/{messageReceiver:slug}/delete', [MessageReceiverController::class, 'destroy']);
        });

        Route::prefix('media-file')->group(function () {
            Route::get('/', [MediaFileController::class, 'index'])->name('media-file.index');
            Route::post('/datatable', [MediaFileController::class, 'datatable']);
            Route::post('/store', [MediaFileController::class, 'store']);
            Route::put('/{mediaFile:slug}/update', [MediaFileController::class, 'update']);
            Route::delete('/{mediaFile:slug}/delete', [MediaFileController::class, 'destroy']);
        });

        Route::prefix('detail-media-file')->group(function () {
            Route::get('/{detailMediaFile:slug}', [DetailMediaFileController::class, 'show'])->name('detail-media-file.show');
            Route::put('/{detailMediaFile:slug}/update', [DetailMediaFileController::class, 'update']);
            Route::delete('/{detailMediaFile:slug}/delete', [DetailMediaFileController::class, 'destroy']);
        });

        // TODO Student Registration
        Route::prefix('student')->group(function () {
            Route::get('/', [StudentController::class, 'index'])->name('student.index')->middleware('only_admin');
            Route::post('/datatable', [StudentController::class, 'datatable']);
        });

        Route::post('student-report-excel', [StudentReportController::class, 'excel']);

        Route::get('student-stats', [StudentStatsController::class, 'index']);

        Route::middleware('student_access')->group(function () {
            Route::get('student/{user:username}/show', [StudentController::class, 'show'])->name('student.show');
            Route::delete('student/{user:username}/delete', [StudentController::class, 'destroy']);
            Route::put('student/{user:username}/restore', [StudentController::class, 'restore']);
            Route::delete('student/{user:username}/permanently-delete', [StudentController::class, 'permanentlyDelete']);

            Route::post('student-validation/{user:username}/store', [ValidationController::class, 'store']);

            Route::post('acceptance-registration/{user:username}/store', [AcceptanceRegistrationController::class, 'store']);

            Route::prefix('student-registration')->group(function () {
                Route::get('/{user:username}', [StudentRegistrationController::class, 'index'])->name('student-registration.index');
                Route::post('/{user:username}/store', [StudentRegistrationController::class, 'store']);
            });

            Route::prefix('personal-data')->group(function () {
                Route::get('/{user:username}', [PersonalDataController::class, 'index'])->name('personal-data.index');
                Route::post('/{user:username}/store', [PersonalDataController::class, 'store']);
            });

            Route::prefix('family')->group(function () {
                Route::get('/{user:username}', [FamilyController::class, 'index'])->name('family.index');
                Route::post('/{user:username}/store', [FamilyController::class, 'store']);
            });

            Route::prefix('place-of-recidence')->group(function () {
                Route::get('/{user:username}', [ResidenceController::class, 'index'])->name('place-of-recidence.index');
                Route::post('/{user:username}/store', [ResidenceController::class, 'store']);
            });

            Route::prefix('previous-school')->group(function () {
                Route::get('/{user:username}', [PreviousSchoolController::class, 'index'])->name('previous-school.index');
                Route::post('/{user:username}/store', [PreviousSchoolController::class, 'store']);
            });

            Route::prefix('file-uploading')->group(function () {
                Route::get('/{user:username}', [FileUploadingController::class, 'index'])->name('file-uploading.index');
                Route::post('/{user:username}/store', [FileUploadingController::class, 'store']);
                Route::delete('/{user:username}/delete', [FileUploadingController::class, 'destroy']);
            });

            Route::prefix('student-security')->group(function () {
                Route::get('/{user:username}/security', [StudentSecurityController::class, 'index'])->name('student-security.index');
                Route::put('/{user:username}/store', [StudentSecurityController::class, 'store']);
            });
        });

        // TODO Select Routes
        Route::get('select-permission', [PermissionController::class, 'select']);
        Route::get('select-main-menu', [MenuController::class, 'select']);
        Route::get('select-educational-level', [EducationalLevelController::class, 'select']);
        Route::get('select-role', [RoleController::class, 'select']);
        Route::get('select-school-year', [SchoolYearController::class, 'select']);
        Route::get('select-message-template', [MessageTemplateController::class, 'select']);
        Route::get('select-message-user', [MessageTemplateController::class, 'selectUser']);
        Route::get('select-media-file', [MediaFileController::class, 'select']);
    });

    Route::prefix('account-verification')->group(function () {
        Route::get('/', [AccountVerificationController::class, 'index'])->name('account-verification.index')->middleware('verification_process');
        Route::get('/account-verification', [AccountVerificationController::class, 'verification'])->name('account-verification.verification')->middleware('verification_process');
        Route::post('/resend', [AccountVerificationController::class, 'resend'])->name('account-verification.resend')->middleware('verification_process');
    });
});

Route::get('select-educational-institution', [EducationalInstitutionController::class, 'select']);
Route::get('select-registration-category', [RegistrationCategoryController::class, 'select']);
Route::get('select-class-level', [ClassLevelController::class, 'select']);
Route::get('select-registration-path', [RegistrationPathController::class, 'select']);
Route::get('select-major', [MajorController::class, 'select']);
