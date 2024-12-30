<?php

namespace Database\Seeders\Setting;

use App\Models\WhatsappConfig;
use Illuminate\Database\Seeder;

class WhatsappConfigSeeder extends Seeder
{
    public function run(): void
    {
        $whatsappConfig = new WhatsappConfig();
        $whatsappConfig->domain = 'https://bdg.wablas.com';
        $whatsappConfig->api_key = 'test';
        $whatsappConfig->is_active = false;
        $whatsappConfig->save();
    }
}
