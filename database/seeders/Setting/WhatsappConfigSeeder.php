<?php

namespace Database\Seeders\Setting;

use App\Models\WhatsappConfig;
use Illuminate\Database\Seeder;

class WhatsappConfigSeeder extends Seeder
{
    public function run(): void
    {
        $whatsappConfig = new WhatsappConfig();
        $whatsappConfig->domain = 'https://bdg.wablas.com/api/v2/send-message';
        $whatsappConfig->api_key = 'vz3Wd95U5Qbb6WOb8sKRoZ1UhrIGdfgYyRqBxOEMGE7hNz1EFZqwi1gOjs37uUV9';
        $whatsappConfig->is_active = false;
        $whatsappConfig->save();
    }
}
