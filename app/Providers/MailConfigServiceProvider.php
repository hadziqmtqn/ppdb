<?php

namespace App\Providers;

use App\Models\EmailConfig;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        try {
            // Periksa koneksi ke database dan keberadaan tabel
            if (Schema::hasTable('email_configs')) {
                Config::set('mail.mailers.smtp.username', EmailConfig::active()->value('mail_username'));
                Config::set('mail.mailers.smtp.password', EmailConfig::active()->value('mail_password_app'));
                Config::set('mail.from.address', EmailConfig::active()->value('mail_username'));
            }
        } catch (Exception $exception) {
            // Log error jika diperlukan atau abaikan
            Log::warning('Unable to configure mail settings: ' . $exception->getMessage());
        }
    }
}
