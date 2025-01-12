<?php

namespace App\Providers;

use App\Policies\EmailChangePolicy;
use App\Policies\UserPolicy;
use App\Repositories\ApplicationRepository;
use App\Repositories\ClassLevelRepository;
use App\Repositories\EducationalInstitutionRepository;
use App\Repositories\EducationalLevelRepository;
use App\Repositories\MajorRepository;
use App\Repositories\MenuRepository;
use App\Repositories\MessageTemplateRepository;
use App\Repositories\ModelRepository;
use App\Repositories\MyAccountRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\RegistrationCategoryRepository;
use App\Repositories\RegistrationPathRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SaveNewAccountRepository;
use App\Repositories\SchoolYearRepository;
use App\Repositories\SendMessage\AccountVerificationRepository;
use App\Repositories\SendMessage\RegistrationMessageRepository;
use App\Repositories\Student\StudentRegistrationRepository;
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
        $this->app->bind(ApplicationRepository::class, ApplicationRepository::class);
        $this->app->bind(MyAccountRepository::class, MyAccountRepository::class);
        $this->app->bind(PermissionRepository::class, PermissionRepository::class);
        $this->app->bind(MenuRepository::class, MenuRepository::class);
        $this->app->bind(RoleRepository::class, RoleRepository::class);
        $this->app->bind(ModelRepository::class, ModelRepository::class);
        $this->app->bind(EducationalLevelRepository::class, EducationalLevelRepository::class);
        $this->app->bind(EducationalInstitutionRepository::class, EducationalInstitutionRepository::class);
        $this->app->bind(SchoolYearRepository::class, SchoolYearRepository::class);
        $this->app->bind(RegistrationCategoryRepository::class, RegistrationCategoryRepository::class);
        $this->app->bind(ClassLevelRepository::class, ClassLevelRepository::class);
        $this->app->bind(RegistrationPathRepository::class, RegistrationPathRepository::class);
        $this->app->bind(MajorRepository::class, MajorRepository::class);
        $this->app->bind(MessageTemplateRepository::class, MessageTemplateRepository::class);
        $this->app->bind(SaveNewAccountRepository::class, SaveNewAccountRepository::class);
        $this->app->bind(StudentRegistrationRepository::class, StudentRegistrationRepository::class);

        // TODO Send Messages
        $this->app->bind(AccountVerificationRepository::class, AccountVerificationRepository::class);
        $this->app->bind(RegistrationMessageRepository::class, RegistrationMessageRepository::class);

        // TODO Policy
        Gate::policy(EmailChangePolicy::class, EmailChangePolicy::class);
        Gate::policy(UserPolicy::class, UserPolicy::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
