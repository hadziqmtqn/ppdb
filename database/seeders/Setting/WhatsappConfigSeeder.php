<?php

namespace Database\Seeders\Setting;

use App\Models\WhatsappConfig;
use Illuminate\Database\Seeder;

class WhatsappConfigSeeder extends Seeder
{
    public function run(): void
    {
        $whatsappConfig = new WhatsappConfig();
        $whatsappConfig->domain = 'https://lite.wanesia.com/api/send_message';
        $whatsappConfig->api_key = 'qhpNsTejpGSLtZ1VJLwPCdUtDViovVKBfkPwfkGdo8ovCcsaGd';
        $whatsappConfig->is_active = false;
        $whatsappConfig->save();
    }
}
