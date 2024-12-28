<?php

namespace App\Providers;

use App\Http\ViewComposers\AppViewComposer;
use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        View::composer('*', AppViewComposer::class);
    }
}
