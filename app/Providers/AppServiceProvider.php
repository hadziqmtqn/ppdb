<?php

namespace App\Providers;

use App\Repositories\ApplicationRepository;
use App\Repositories\EducationalInstitutionRepository;
use App\Repositories\EducationalLevelRepository;
use App\Repositories\MenuRepository;
use App\Repositories\ModelRepository;
use App\Repositories\MyAccountRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
