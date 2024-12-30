<?php

namespace Database\Seeders\Setting;

use App\Models\EmailConfig;
use Illuminate\Database\Seeder;

class EmailConfigSeeder extends Seeder
{
    public function run(): void
    {
        $emailConfig = new EmailConfig();
        $emailConfig->mail_username = 'hadziq.id@gmail.com';
        $emailConfig->mail_password_app = 'ddvevqxbwmrlrvmy';
        $emailConfig->save();
    }
}
