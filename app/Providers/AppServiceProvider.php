<?php

namespace App\Providers;

use App\Repositories\ApplicationRepository;
use App\Repositories\MyAccountRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
