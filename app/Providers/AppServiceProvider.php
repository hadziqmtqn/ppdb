<?php

namespace App\Providers;

use App\Repositories\ApplicationRepository;
use App\Repositories\MenuRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
