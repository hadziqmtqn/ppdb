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
use App\Http\Controllers\Dashboard\Messages\ConversationController;
use App\Http\Controllers\Dashboard\Messages\MessageController;
use App\Http\Controllers\Dashboard\Payment\BankAccountController;
use App\Http\Controllers\Dashboard\Payment\PaymentChannelController;
use App\Http\Controllers\Dashboard\Payment\PaymentController;
use App\Http\Controllers\Dashboard\Payment\PaymentSettingController;
use App\Http\Controllers\Dashboard\Payment\PaymentTransactionController;
use App\Http\Controllers\Dashboard\Payment\RegistrationFeeController;
use App\Http\Controllers\Dashboard\Payment\WebhookController;
use App\Http\Controllers\Dashboard\References\ClassLevelController;
use App\Http\Controllers\Dashboard\References\DetailMediaFileController;
use App\Http\Controllers\Dashboard\References\DistanceToSchoolController;
use App\Http\Controllers\Dashboard\References\EducationalInstitutionController;
use App\Http\Controllers\Dashboard\References\EducationalLevelController;
use App\Http\Controllers\Dashboard\References\EducationController;
use App\Http\Controllers\Dashboard\References\IncomeController;
use App\Http\Controllers\Dashboard\References\MajorController;
use App\Http\Controllers\Dashboard\References\MediaFileController;
use App\Http\Controllers\Dashboard\References\PreviousSchoolReferenceController;
use App\Http\Controllers\Dashboard\References\ProfessionController;
use App\Http\Controllers\Dashboard\References\RegistrationCategoryController;
use App\Http\Controllers\Dashboard\References\RegistrationPathController;
use App\Http\Controllers\Dashboard\References\RegistrationScheduleController;
use App\Http\Controllers\Dashboard\References\SchoolYearController;
use App\Http\Controllers\Dashboard\References\TransportationController;
use App\Http\Controllers\Dashboard\SchoolReport\LessonController;
use App\Http\Controllers\Dashboard\SchoolReport\LessonMappingController;
use App\Http\Controllers\Dashboard\Setting\ApplicationController;
use App\Http\Controllers\Dashboard\Setting\EducationalGroupController;
use App\Http\Controllers\Dashboard\Setting\EmailConfigController;
use App\Http\Controllers\Dashboard\Setting\Faq\FaqCategoryController;
use App\Http\Controllers\Dashboard\Setting\Faq\FaqController;
use App\Http\Controllers\Dashboard\Setting\MenuController;
use App\Http\Controllers\Dashboard\Setting\MessageReceiverController;
use App\Http\Controllers\Dashboard\Setting\MessageTemplateController;
use App\Http\Controllers\Dashboard\Setting\PermissionController;
use App\Http\Controllers\Dashboard\Setting\RegistrationSettingController;
use App\Http\Controllers\Dashboard\Setting\RegistrationStepController;
use App\Http\Controllers\Dashboard\Setting\RoleController;
use App\Http\Controllers\Dashboard\Setting\WhatsappConfigController;
use App\Http\Controllers\Dashboard\Student\AcceptanceRegistrationController;
use App\Http\Controllers\Dashboard\Student\FamilyController;
use App\Http\Controllers\Dashboard\Student\FileUploadingController;
use App\Http\Controllers\Dashboard\Student\Payment\CurrentBillController;
use App\Http\Controllers\Dashboard\Student\PersonalDataController;
use App\Http\Controllers\Dashboard\Student\PreviousSchoolController;
use App\Http\Controllers\Dashboard\Student\ResidenceController;
use App\Http\Controllers\Dashboard\Student\SchoolReportController;
use App\Http\Controllers\Dashboard\Student\SchoolValueReportController;
use App\Http\Controllers\Dashboard\Student\StudentController;
use App\Http\Controllers\Dashboard\Student\StudentRegistrationController;
use App\Http\Controllers\Dashboard\Student\StudentReportController;
use App\Http\Controllers\Dashboard\Student\StudentSecurityController;
use App\Http\Controllers\Dashboard\Student\StudentStatsController;
use App\Http\Controllers\Dashboard\Student\ValidationController;
use App\Http\Controllers\Dashboard\UserDashboardController;
use App\Http\Controllers\Home\ContactUsController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('get-faq-categories', [HomeController::class, 'getFaqCategories']);
Route::get('get-faqs', [HomeController::class, 'getFaqs']);

Route::post('contact-us', [ContactUsController::class, 'store'])->name('contact-us.store');

Route::middleware('guest')->group(function () {
    Route::group(['prefix' => 'login'], function () {
        Route::get('/', [LoginController::class, 'index'])->name('login');
        Route::post('/store', [LoginController::class, 'store'])->name('login.store');
    });

    Route::group(['prefix' => 'oauth'], function () {
        Route::get('/{provider}', [OAuthController::class, 'redirectToProvider'])->name('oauth.redirect-to-provider');
        Route::get('/{provider}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.handle-callback');
    });

    Route::group(['prefix' => 'register'], function () {
        Route::get('/', [RegistrationController::class, 'index'])->name('registration.index');
        Route::post('/store', [RegistrationController::class, 'store']);
    });
});

//Broadcast::routes(['middleware' => ['auth']]);

Route::middleware('auth')->group(function () {
    Route::middleware('account_verified')->group(function () {
        // TODO Auth
        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
        Route::post('password-validation', [PasswordValidationController::class, 'store']);

        // TODO Dashboard
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard')->middleware('admin.dashboard');
        Route::get('user-dashboard', [UserDashboardController::class, 'index'])->name('user-dashboard.index')->middleware('user.dashboard');

        Route::get('student-stats-dashboard', [AdminDashboardController::class, 'studentStats']);
        Route::post('previous-school-reference-datatable', [AdminDashboardController::class, 'previousSchoolReferenceDatatable']);

        Route::group(['prefix' => 'account'], function () {
            Route::get('/', [AccountController::class, 'index'])->name('account.index');
            Route::post('/update', [AccountController::class, 'update'])->name('account.update');
        });

        Route::group(['prefix' => 'menu'], function () {
            Route::get('/', [MenuController::class, 'index'])->name('menu.index');
            Route::post('/store', [MenuController::class, 'store'])->name('menu.store');
            Route::post('/datatable', [MenuController::class, 'datatable']);
            Route::get('/{menu:slug}', [MenuController::class, 'edit'])->name('menu.edit');
            Route::put('/{menu:slug}/update', [MenuController::class, 'update'])->name('menu.update');
            Route::delete('/{menu:slug}/delete', [MenuController::class, 'destroy']);
        });

        Route::get('search-menu', [MenuController::class, 'searchMenu']);

        Route::group(['prefix' => 'role'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('role.index');
            Route::post('/datatable', [RoleController::class, 'datatable']);
            Route::get('/{role:slug}', [RoleController::class, 'edit'])->name('role.edit');
            Route::put('/{role:slug}/update', [RoleController::class, 'update'])->name('role.update');
        });

        Route::group(['prefix' => 'application'], function () {
            Route::get('/', [ApplicationController::class, 'index'])->name('application.index');
            Route::post('/', [ApplicationController::class, 'store'])->name('application.store');
            Route::get('/{application:slug}', [ApplicationController::class, 'assets'])->name('application.assets');
            Route::post('/{application:slug}/save-assets', [ApplicationController::class, 'saveAssets'])->name('application.save-assets');
            Route::delete('/{application:slug}/delete-assets', [ApplicationController::class, 'deleteAssets'])->name('application.delete-assets');
        });

        Route::group(['prefix' => 'educational-level'], function () {
            Route::get('/', [EducationalLevelController::class, 'index'])->name('educational-level.index');
            Route::post('/datatable', [EducationalLevelController::class, 'datatable']);
            Route::put('/{educationalLevel:slug}/store', [EducationalLevelController::class, 'store']);
        });

        Route::group(['prefix' => 'educational-institution'], function () {
            Route::get('/', [EducationalInstitutionController::class, 'index'])->name('educational-institution.index');
            Route::post('/datatable', [EducationalInstitutionController::class, 'datatable']);
            Route::post('/store', [EducationalInstitutionController::class, 'store'])->name('educational-institution.store');
            Route::get('/{educationalInstitution:slug}', [EducationalInstitutionController::class, 'show'])->name('educational-institution.show');
            Route::put('/{educationalInstitution:slug}/update', [EducationalInstitutionController::class, 'update'])->name('educational-institution.update');
        });

        Route::group(['prefix' => 'whatsapp-config'], function () {
            Route::get('/', [WhatsAppConfigController::class, 'index'])->name('whatsapp-config.index');
            Route::post('/datatable', [WhatsAppConfigController::class, 'datatable']);
            Route::put('/{whatsappConfig:slug}/update', [WhatsAppConfigController::class, 'update']);
        });

        Route::group(['prefix' => 'email-config'], function () {
            Route::get('/', [EmailConfigController::class, 'index'])->name('email-config.index');
            Route::post('/store', [EmailConfigController::class, 'store'])->name('email-config.store');
        });

        Route::group(['prefix' => 'admin'], function () {
            Route::get('/', [AdminController::class, 'index'])->name('admin.index');
            Route::post('/datatable', [AdminController::class, 'datatable']);
            Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
            Route::get('/{user:username}', [AdminController::class, 'show'])->name('admin.show');
            Route::put('/{user:username}/update', [AdminController::class, 'update'])->name('admin.update');
            Route::delete('/{user:username}/delete', [AdminController::class, 'destroy']);
            Route::post('/{user:username}/restore', [AdminController::class, 'restore']);
            Route::delete('/{user:username}/force-delete', [AdminController::class, 'forceDelete']);
        });

        Route::group(['prefix' => 'message-template'], function () {
            Route::get('/', [MessageTemplateController::class, 'index'])->name('message-template.index');
            Route::post('/store', [MessageTemplateController::class, 'store'])->name('message-template.store');
            Route::post('/datatable', [MessageTemplateController::class, 'datatable']);
            Route::get('/{messageTemplate:slug}', [MessageTemplateController::class, 'show'])->name('message-template.show');
            Route::put('/{messageTemplate:slug}/update', [MessageTemplateController::class, 'update'])->name('message-template.update');
            Route::delete('/{messageTemplate:slug}/delete', [MessageTemplateController::class, 'destroy']);
        });

        Route::get('email-verification', [EmailChangeController::class, 'verification'])->name('email-change.verification');

        Route::group(['prefix' => 'school-year'], function () {
            Route::get('/', [SchoolYearController::class, 'index'])->name('school-year.index');
            Route::post('/datatable', [SchoolYearController::class, 'datatable']);
            Route::post('/store', [SchoolYearController::class, 'store'])->name('school-year.store');
            Route::get('/{schoolYear:slug}', [SchoolYearController::class, 'show'])->name('school-year.show');
            Route::put('/{schoolYear:slug}/update', [SchoolYearController::class, 'update'])->name('school-year.update');
        });

        Route::group(['prefix' => 'registration-schedule'], function () {
            Route::post('/datatable', [RegistrationScheduleController::class, 'datatable']);
            Route::post('/store', [RegistrationScheduleController::class, 'store']);
            Route::put('/{registrationSchedule:slug}/update', [RegistrationScheduleController::class, 'update']);
        });

        Route::group(['prefix' => 'registration-category'], function () {
            Route::get('/', [RegistrationCategoryController::class, 'index'])->name('registration-category.index');
            Route::post('/datatable', [RegistrationCategoryController::class, 'datatable']);
            Route::post('/store', [RegistrationCategoryController::class, 'store'])->name('registration-category.store');
            Route::put('/{registrationCategory:slug}/update', [RegistrationCategoryController::class, 'update']);
            Route::delete('/{registrationCategory:slug}/delete', [RegistrationCategoryController::class, 'destroy']);
        });

        Route::group(['prefix' => 'class-level'], function () {
            Route::get('/', [ClassLevelController::class, 'index'])->name('class-level.index');
            Route::post('/datatable', [ClassLevelController::class, 'datatable']);
            Route::post('/store', [ClassLevelController::class, 'store']);
            Route::put('/{classLevel:slug}/update', [ClassLevelController::class, 'update']);
            Route::delete('/{classLevel:slug}/delete', [ClassLevelController::class, 'destroy']);
        });

        Route::group(['prefix' => 'registration-path'], function () {
            Route::get('/', [RegistrationPathController::class, 'index'])->name('registration-path.index');
            Route::post('/datatable', [RegistrationPathController::class, 'datatable']);
            Route::post('/store', [RegistrationPathController::class, 'store']);
            Route::put('/{registrationPath:slug}/update', [RegistrationPathController::class, 'update']);
            Route::delete('/{registrationPath:slug}/delete', [RegistrationPathController::class, 'destroy']);
        });

        Route::group(['prefix' => 'major'], function () {
            Route::get('/', [MajorController::class, 'index'])->name('major.index');
            Route::post('/datatable', [MajorController::class, 'datatable']);
            Route::post('/store', [MajorController::class, 'store']);
            Route::put('/{major:slug}/update', [MajorController::class, 'update']);
            Route::delete('/{major:slug}/delete', [MajorController::class, 'destroy']);
        });

        Route::group(['prefix' => 'distance-to-school'], function () {
            Route::get('/', [DistanceToSchoolController::class, 'index'])->name('distance-to-school.index');
            Route::post('/datatable', [DistanceToSchoolController::class, 'datatable']);
            Route::post('/store', [DistanceToSchoolController::class, 'store']);
            Route::put('/{distanceToSchool:slug}/update', [DistanceToSchoolController::class, 'update']);
            Route::delete('/{distanceToSchool:slug}/delete', [DistanceToSchoolController::class, 'destroy']);
        });

        Route::group(['prefix' => 'transportation'], function () {
            Route::get('/', [TransportationController::class, 'index'])->name('transportation.index');
            Route::post('/datatable', [TransportationController::class, 'datatable']);
            Route::post('/store', [TransportationController::class, 'store']);
            Route::put('/{transportation:slug}/update', [TransportationController::class, 'update']);
            Route::delete('/{transportation:slug}/delete', [TransportationController::class, 'destroy']);
        });

        Route::group(['prefix' => 'profession'], function () {
            Route::get('/', [ProfessionController::class, 'index'])->name('profession.index');
            Route::post('/datatable', [ProfessionController::class, 'datatable']);
            Route::post('/store', [ProfessionController::class, 'store']);
            Route::put('/{profession:slug}/update', [ProfessionController::class, 'update']);
            Route::delete('/{profession:slug}/delete', [ProfessionController::class, 'destroy']);
        });

        Route::group(['prefix' => 'education'], function () {
            Route::get('/', [EducationController::class, 'index'])->name('education.index');
            Route::post('/datatable', [EducationController::class, 'datatable']);
            Route::post('/store', [EducationController::class, 'store']);
            Route::put('/{education:slug}/update', [EducationController::class, 'update']);
            Route::delete('/{education:slug}/delete', [EducationController::class, 'destroy']);
        });

        Route::group(['prefix' => 'income'], function () {
            Route::get('/', [IncomeController::class, 'index'])->name('income.index');
            Route::post('/datatable', [IncomeController::class, 'datatable']);
            Route::post('/store', [IncomeController::class, 'store']);
            Route::put('/{income:slug}/update', [IncomeController::class, 'update']);
            Route::delete('/{income:slug}/delete', [IncomeController::class, 'destroy']);
        });

        Route::group(['prefix' => 'message-receiver'], function () {
            Route::post('/store', [MessageReceiverController::class, 'store']);
            Route::post('/datatable', [MessageReceiverController::class, 'datatable']);
            Route::delete('/{messageReceiver:slug}/delete', [MessageReceiverController::class, 'destroy']);
        });

        Route::group(['prefix' => 'media-file'], function () {
            Route::get('/', [MediaFileController::class, 'index'])->name('media-file.index');
            Route::post('/datatable', [MediaFileController::class, 'datatable']);
            Route::post('/store', [MediaFileController::class, 'store']);
            Route::put('/{mediaFile:slug}/update', [MediaFileController::class, 'update']);
            Route::delete('/{mediaFile:slug}/delete', [MediaFileController::class, 'destroy']);
        });

        Route::group(['prefix' => 'detail-media-file'], function () {
            Route::get('/{detailMediaFile:slug}', [DetailMediaFileController::class, 'show'])->name('detail-media-file.show');
            Route::put('/{detailMediaFile:slug}/update', [DetailMediaFileController::class, 'update']);
            Route::delete('/{detailMediaFile:slug}/delete', [DetailMediaFileController::class, 'destroy']);
        });

        Route::group(['prefix' => 'registration-step'], function () {
            Route::get('/', [RegistrationStepController::class, 'index'])->name('registration-step.index');
            Route::post('/datatable', [RegistrationStepController::class, 'datatable']);
            Route::post('/store', [RegistrationStepController::class, 'store'])->name('registration-step.store');
            Route::get('/{registrationStep:slug}', [RegistrationStepController::class, 'show'])->name('registration-step.show');
            Route::put('/{registrationStep:slug}/update', [RegistrationStepController::class, 'update'])->name('registration-step.update');
            Route::delete('/{registrationStep:slug}/delete', [RegistrationStepController::class, 'destroy']);
        });

        Route::group(['prefix' => 'faq-category'], function () {
            Route::get('/', [FaqCategoryController::class, 'index'])->name('faq-category.index');
            Route::post('/store', [FaqCategoryController::class, 'store'])->name('faq-category.store');
            Route::delete('/{faqCategory:slug}/delete', [FaqCategoryController::class, 'destroy'])->name('faq-category.destroy');
        });

        Route::group(['prefix' => 'faq'], function () {
            Route::get('/', [FaqController::class, 'index'])->name('faq.index');
            Route::post('/store', [FaqController::class, 'store'])->name('faq.store');
            Route::post('/datatable', [FaqController::class, 'datatable']);
            Route::get('/{faq:slug}/show', [FaqController::class, 'show'])->name('faq.show');
            Route::put('/{faq:slug}/update', [FaqController::class, 'update'])->name('faq.update');
            Route::delete('/{faq:slug}/delete', [FaqController::class, 'destroy']);
        });

        Route::group(['prefix' => 'registration-setting'], function () {
            Route::get('/', [RegistrationSettingController::class, 'index'])->name('registration-setting.index');
            Route::post('/datatable', [RegistrationSettingController::class, 'datatable']);
            Route::post('/store', [RegistrationSettingController::class, 'store']);
            Route::get('/{registrationSetting:slug}/show', [RegistrationSettingController::class, 'show'])->name('registration-setting.show');
            Route::put('/{registrationSetting:slug}/update', [RegistrationSettingController::class, 'update']);
        });

        Route::group(['prefix' => 'educational-group'], function () {
            Route::get('/', [EducationalGroupController::class, 'index'])->name('educational-group.index');
            Route::post('/datatable', [EducationalGroupController::class, 'datatable']);
            Route::post('/store', [EducationalGroupController::class, 'store']);
            Route::put('/{educationalGroup:slug}/update', [EducationalGroupController::class, 'update']);
        });

        Route::group(['prefix' => 'previous-school-reference'], function () {
            Route::get('/', [PreviousSchoolReferenceController::class, 'index'])->name('previous-school-reference.index');
            Route::post('/datatable', [PreviousSchoolReferenceController::class, 'datatable']);
            Route::post('/store', [PreviousSchoolReferenceController::class, 'store']);
            Route::get('/{previousSchoolReference:slug}', [PreviousSchoolReferenceController::class, 'show'])->name('previous-school-reference.show');
            Route::put('/{previousSchoolReference:slug}/update', [PreviousSchoolReferenceController::class, 'update']);
            Route::delete('/{previousSchoolReference:slug}/delete', [PreviousSchoolReferenceController::class, 'destroy']);
        });

        // TODO Payment
        Route::group(['prefix' => 'payment-setting'], function () {
            Route::get('/', [PaymentSettingController::class, 'index'])->name('payment-setting.index');
            Route::post('/store', [PaymentSettingController::class, 'store']);
            Route::post('/datatable', [PaymentSettingController::class, 'datatable']);
            Route::put('/{paymentSetting:slug}/update', [PaymentSettingController::class, 'update']);
        });

        Route::group(['prefix' => 'payment-channel'], function () {
            Route::get('/', [PaymentChannelController::class, 'index'])->name('payment-channel.index');
            Route::post('/datatable', [PaymentChannelController::class, 'datatable']);
            Route::put('/{paymentChannel:slug}/update', [PaymentChannelController::class, 'update']);
        });

        Route::group(['prefix' => 'bank-account'], function () {
            Route::get('/', [BankAccountController::class, 'index'])->name('bank-account.index');
            Route::post('/datatable', [BankAccountController::class, 'datatable']);
            Route::post('/store', [BankAccountController::class, 'store']);
            Route::put('/{bankAccount:slug}/update', [BankAccountController::class, 'update']);
            Route::delete('/{bankAccount:slug}/delete', [BankAccountController::class, 'destroy']);
        });

        Route::group(['prefix' => 'registration-fee'], function () {
            Route::get('/', [RegistrationFeeController::class, 'index'])->name('registration-fee.index');
            Route::post('/datatable', [RegistrationFeeController::class, 'datatable']);
            Route::post('/store', [RegistrationFeeController::class, 'store']);
            Route::put('/{registrationFee:slug}/update', [RegistrationFeeController::class, 'update']);
            Route::delete('/{registrationFee:slug}/delete', [RegistrationFeeController::class, 'destroy']);
        });

        Route::group(['prefix' => 'payment-transaction'], function () {
            Route::get('/', [PaymentTransactionController::class, 'index'])->name('payment-transaction.index');
            Route::post('/datatable', [PaymentTransactionController::class, 'datatable']);
            Route::get('/{payment:slug}', [PaymentTransactionController::class, 'show'])->name('payment-transaction.show');
            Route::put('/{payment:slug}/confirmation', [PaymentTransactionController::class, 'confirm'])->name('payment-transaction.confirm');
            Route::get('/{payment:slug}/check-payment', [PaymentTransactionController::class, 'checkPayment']);
            Route::put('/{payment:slug}/validation', [PaymentTransactionController::class, 'paymentValidation']);
            Route::delete('/{payment:slug}/delete', [PaymentTransactionController::class, 'destroy']);
        });

        // TODO Message
        Route::group(['prefix' => 'conversation'], function () {
            Route::get('/', [ConversationController::class, 'index'])->name('conversation.index');
            Route::post('/datatable', [ConversationController::class, 'datatable']);
            Route::post('/store', [ConversationController::class, 'store']);
            Route::get('/{conversation:slug}/show', [ConversationController::class, 'show'])->name('conversation.show');
            Route::delete('/{conversation:slug}/delete', [ConversationController::class, 'destroy']);

            Route::get('/select-students', [ConversationController::class, 'selectStudent']);
        });

        Route::group(['prefix' => 'message'], function () {
            Route::get('/{conversation:slug}', [MessageController::class, 'index']);
            Route::get('/{conversation:slug}/latest', [MessageController::class, 'latest']);
            Route::post('/{conversation:slug}/reply-message', [MessageController::class, 'replyMessage']);
            Route::delete('/{message:slug}/delete', [MessageController::class, 'destroy']);
            Route::patch('/{message:slug}/read', [MessageController::class, 'read']);
        });

        // TODO School Report
        Route::group(['prefix' => 'lesson'], function () {
            Route::get('/', [LessonController::class, 'index'])->name('lesson.index');
            Route::post('/datatable', [LessonController::class, 'datatable']);
            Route::post('/store', [LessonController::class, 'store']);
            Route::put('/{lesson:slug}/update', [LessonController::class, 'update']);
            Route::delete('/{lesson:slug}/delete', [LessonController::class, 'destroy']);
        });

        Route::group(['prefix' => 'lesson-mapping'], function () {
            Route::get('/', [LessonMappingController::class, 'index'])->name('lesson-mapping.index');
            Route::post('/datatable', [LessonMappingController::class, 'datatable']);
            Route::post('/store', [LessonMappingController::class, 'store']);
            Route::get('/{lessonMapping:slug}/show', [LessonMappingController::class, 'show'])->name('lesson-mapping.show');
            Route::put('/{lessonMapping:slug}/update', [LessonMappingController::class, 'update']);
            Route::delete('/{lessonMapping:slug}/delete', [LessonMappingController::class, 'destroy']);
        });

        // TODO Student Registration
        Route::group(['prefix' => 'student'], function () {
            Route::get('/', [StudentController::class, 'index'])->name('student.index')->middleware('only_admin');
            Route::post('/datatable', [StudentController::class, 'datatable']);
            Route::put('/{username}/restore', [StudentController::class, 'restore']);
            Route::delete('/{username}/permanently-delete', [StudentController::class, 'permanentlyDelete']);
        });

        Route::post('student-report-excel', [StudentReportController::class, 'excel']);
        Route::get('student-report-pdf/{user:username}', [StudentReportController::class, 'pdf'])->name('student-report-pdf-user:username');

        Route::get('student-stats', [StudentStatsController::class, 'index']);

        Route::get('school-report', [SchoolValueReportController::class, 'index'])->name('school-report');
        Route::group(['prefix' => 'school-value-report'], function () {
            Route::post('/datatable', [SchoolValueReportController::class, 'datatable']);
            Route::post('/export', [SchoolValueReportController::class, 'export']);
        });

        Route::middleware('student_access')->group(function () {
            Route::get('student/{user:username}/show', [StudentController::class, 'show'])->name('student.show');
            Route::put('student/{user:username}/inactive', [StudentController::class, 'inactive'])->name('student.inactive');
            Route::delete('student/{user:username}/delete', [StudentController::class, 'destroy']);

            Route::post('student-validation/{user:username}/store', [ValidationController::class, 'store']);

            Route::post('acceptance-registration/{user:username}/store', [AcceptanceRegistrationController::class, 'store']);

            Route::group(['prefix' => 'student-registration'], function () {
                Route::get('/{user:username}', [StudentRegistrationController::class, 'index'])->name('student-registration.index');
                Route::post('/{user:username}/store', [StudentRegistrationController::class, 'store']);
            });

            Route::group(['prefix' => 'personal-data'], function () {
                Route::get('/{user:username}', [PersonalDataController::class, 'index'])->name('personal-data.index');
                Route::post('/{user:username}/store', [PersonalDataController::class, 'store']);
            });

            Route::group(['prefix' => 'family'], function () {
                Route::get('/{user:username}', [FamilyController::class, 'index'])->name('family.index');
                Route::post('/{user:username}/store', [FamilyController::class, 'store']);
            });

            Route::group(['prefix' => 'place-of-recidence'], function () {
                Route::get('/{user:username}', [ResidenceController::class, 'index'])->name('place-of-recidence.index');
                Route::post('/{user:username}/store', [ResidenceController::class, 'store']);
            });

            Route::group(['prefix' => 'previous-school'], function () {
                Route::get('/{user:username}', [PreviousSchoolController::class, 'index'])->name('previous-school.index');
                Route::post('/{user:username}/store', [PreviousSchoolController::class, 'store']);
            });

            Route::group(['prefix' => 'file-uploading'], function () {
                Route::get('/{user:username}', [FileUploadingController::class, 'index'])->name('file-uploading.index');
                Route::post('/{user:username}/store', [FileUploadingController::class, 'store']);
                Route::delete('/{user:username}/delete', [FileUploadingController::class, 'destroy']);
            });

            Route::group(['prefix' => 'student-security'], function () {
                Route::get('/{user:username}/security', [StudentSecurityController::class, 'index'])->name('student-security.index');
                Route::put('/{user:username}/store', [StudentSecurityController::class, 'store']);
            });

            Route::group(['prefix' => 'current-bill'], function () {
                Route::get('/{user:username}', [CurrentBillController::class, 'index'])->name('current-bill.index');
            });

            Route::post('payment/{user:username}/store', [PaymentController::class, 'store']);

            Route::group(['prefix' => 'school-report', 'middleware' => 'registration_is_completed'], function () {
                Route::get('/{user:username}', [SchoolReportController::class, 'index'])->name('school-report.index');
                Route::post('/{user:username}/store', [SchoolReportController::class, 'store']);
                Route::post('/{user:username}/store-report-file', [SchoolReportController::class, 'storeReportFile']);
                Route::delete('/{user:username}/delete-report-file', [SchoolReportController::class, 'deleteReportFile']);
            });

            Route::get('school-value-report/{user:username}', [SchoolValueReportController::class, 'show'])->name('school-value-report.show');
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
        Route::get('select-bank-account', [BankAccountController::class, 'select']);
        Route::get('select-educational-group', [EducationalGroupController::class, 'select']);
        Route::get('select-educational-group/single-select', [EducationalGroupController::class, 'singleSelect']);
        Route::get('select-previous-school-reference', [PreviousSchoolReferenceController::class, 'select']);
    });

    Route::group(['prefix' => 'account-verification'], function () {
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

// TODO Xendit Webhook
Route::post('payment-webhook', [WebhookController::class, 'handleWebhook']);
