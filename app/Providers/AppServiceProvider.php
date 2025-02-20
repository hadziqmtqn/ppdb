<?php

namespace App\Providers;

use App\Policies\ConversationPolicy;
use App\Policies\EmailChangePolicy;
use App\Policies\PaymentPolicy;
use App\Policies\SchoolReportPolicy;
use App\Policies\UserPolicy;
use App\Repositories\ApplicationRepository;
use App\Repositories\ClassLevelRepository;
use App\Repositories\EducationalGroupRepository;
use App\Repositories\EducationalInstitutionRepository;
use App\Repositories\EducationalLevelRepository;
use App\Repositories\FaqRepository;
use App\Repositories\HomeRepository;
use App\Repositories\MajorRepository;
use App\Repositories\MediaFileRepository;
use App\Repositories\MenuRepository;
use App\Repositories\Message\ConversationRepository;
use App\Repositories\MessageTemplateRepository;
use App\Repositories\ModelRepository;
use App\Repositories\MyAccountRepository;
use App\Repositories\Payment\BankAccountRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\RegistrationCategoryRepository;
use App\Repositories\RegistrationPathRepository;
use App\Repositories\RegistrationScheduleRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SaveNewAccountRepository;
use App\Repositories\SchoolYearRepository;
use App\Repositories\SendMessage\AcceptanceRegistrationRepository;
use App\Repositories\SendMessage\AccountVerificationRepository;
use App\Repositories\SendMessage\PaymentBillRepository;
use App\Repositories\SendMessage\PaymentCallbackRepository;
use App\Repositories\SendMessage\RegistrationMessageRepository;
use App\Repositories\SendMessage\SafetyChangesRepository;
use App\Repositories\Student\Payment\CurrentBillRepository;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Student\StudentStatsRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // TODO Regular
        $this->app->singleton(ApplicationRepository::class, ApplicationRepository::class);
        $this->app->singleton(MyAccountRepository::class, MyAccountRepository::class);
        $this->app->singleton(PermissionRepository::class, PermissionRepository::class);
        $this->app->singleton(MenuRepository::class, MenuRepository::class);
        $this->app->singleton(RoleRepository::class, RoleRepository::class);
        $this->app->singleton(ModelRepository::class, ModelRepository::class);
        $this->app->singleton(EducationalLevelRepository::class, EducationalLevelRepository::class);
        $this->app->singleton(EducationalInstitutionRepository::class, EducationalInstitutionRepository::class);
        $this->app->singleton(SchoolYearRepository::class, SchoolYearRepository::class);
        $this->app->singleton(RegistrationCategoryRepository::class, RegistrationCategoryRepository::class);
        $this->app->singleton(ClassLevelRepository::class, ClassLevelRepository::class);
        $this->app->singleton(RegistrationPathRepository::class, RegistrationPathRepository::class);
        $this->app->singleton(MajorRepository::class, MajorRepository::class);
        $this->app->singleton(MessageTemplateRepository::class, MessageTemplateRepository::class);
        $this->app->singleton(SaveNewAccountRepository::class, SaveNewAccountRepository::class);
        $this->app->singleton(StudentRegistrationRepository::class, StudentRegistrationRepository::class);
        $this->app->singleton(MediaFileRepository::class, MediaFileRepository::class);
        $this->app->singleton(StudentRepository::class, StudentRepository::class);
        $this->app->singleton(StudentStatsRepository::class, StudentStatsRepository::class);
        $this->app->singleton(CurrentBillRepository::class, CurrentBillRepository::class);
        $this->app->singleton(BankAccountRepository::class, BankAccountRepository::class);
        $this->app->singleton(HomeRepository::class, HomeRepository::class);
        $this->app->singleton(RegistrationScheduleRepository::class, RegistrationScheduleRepository::class);
        $this->app->singleton(FaqRepository::class, FaqRepository::class);
        $this->app->singleton(ConversationRepository::class, ConversationRepository::class);
        $this->app->singleton(EducationalGroupRepository::class, EducationalGroupRepository::class);

        // TODO Send Messages
        $this->app->singleton(AccountVerificationRepository::class, AccountVerificationRepository::class);
        $this->app->singleton(RegistrationMessageRepository::class, RegistrationMessageRepository::class);
        $this->app->singleton(SafetyChangesRepository::class, SafetyChangesRepository::class);
        $this->app->singleton(AcceptanceRegistrationRepository::class, AcceptanceRegistrationRepository::class);
        $this->app->singleton(PaymentBillRepository::class, PaymentBillRepository::class);
        $this->app->singleton(PaymentCallbackRepository::class, PaymentCallbackRepository::class);

        // TODO Policy
        Gate::policy(EmailChangePolicy::class, EmailChangePolicy::class);
        Gate::policy(UserPolicy::class, UserPolicy::class);
        Gate::policy(ConversationPolicy::class, ConversationPolicy::class);
        Gate::policy(PaymentPolicy::class, PaymentPolicy::class);
        Gate::policy(SchoolReportPolicy::class, SchoolReportPolicy::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
