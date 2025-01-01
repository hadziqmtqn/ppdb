<?php

use SocialiteProviders\Manager\ServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    ServiceProvider::class,
    Yajra\DataTables\DataTablesServiceProvider::class,
    App\Providers\ComposerServiceProvider::class,
    App\Providers\MailConfigServiceProvider::class,
];
