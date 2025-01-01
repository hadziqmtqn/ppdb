<?php

namespace App\Providers;

use App\Models\EmailConfig;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        Config::set('mail.mailers.smtp.username', EmailConfig::active()->value('mail_username'));
        Config::set('mail.mailers.smtp.password', EmailConfig::active()->value('mail_password_app'));
        Config::set('mail.from.address', EmailConfig::active()->value('mail_username'));
    }
}
