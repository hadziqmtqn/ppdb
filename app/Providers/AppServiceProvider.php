<?php

namespace App\Providers;

use App\Policies\EmailChangePolicy;
use App\Repositories\ApplicationRepository;
use App\Repositories\ClassLevelRepository;
use App\Repositories\EducationalInstitutionRepository;
use App\Repositories\EducationalLevelRepository;
use App\Repositories\MajorRepository;
use App\Repositories\MenuRepository;
use App\Repositories\ModelRepository;
use App\Repositories\MyAccountRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\RegistrationCategoryRepository;
use App\Repositories\RegistrationPathRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SchoolYearRepository;
use App\Repositories\SendMessage\EmailChangeRepository;
use App\Repositories\Student\RegisterRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ApplicationRepository::class, ApplicationRepository::class);
        $this->app->bind(MyAccountRepository::class, MyAccountRepository::class);
        $this->app->bind(PermissionRepository::class, PermissionRepository::class);
        $this->app->bind(MenuRepository::class, MenuRepository::class);
        $this->app->bind(RoleRepository::class, RoleRepository::class);
        $this->app->bind(ModelRepository::class, ModelRepository::class);
        $this->app->bind(EducationalLevelRepository::class, EducationalLevelRepository::class);
        $this->app->bind(EducationalInstitutionRepository::class, EducationalInstitutionRepository::class);
        $this->app->bind(EmailChangeRepository::class, EmailChangeRepository::class);
        $this->app->bind(SchoolYearRepository::class, SchoolYearRepository::class);
        $this->app->bind(RegistrationCategoryRepository::class, RegistrationCategoryRepository::class);
        $this->app->bind(ClassLevelRepository::class, ClassLevelRepository::class);
        $this->app->bind(RegistrationPathRepository::class, RegistrationPathRepository::class);
        $this->app->bind(MajorRepository::class, MajorRepository::class);
        $this->app->bind(RegisterRepository::class, RegisterRepository::class);

        Gate::policy(EmailChangePolicy::class, EmailChangePolicy::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
