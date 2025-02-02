<?php

namespace Database\Seeders\Setting;

use App\Models\WhatsappConfig;
use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class WhatsappConfigSeeder extends Seeder
{
    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        $rows = Reader::createFromPath(database_path('import/whatsapp-config.csv'))
            ->setHeaderOffset(0);

        foreach ($rows as $row) {
            $whatsappConfig = new WhatsappConfig();
            $whatsappConfig->domain = $row['domain'];
            $whatsappConfig->api_key = $row['api_key'];
            $whatsappConfig->provider = $row['provider'];
            $whatsappConfig->is_active = $row['is_active'];
            $whatsappConfig->save();
        }
    }
}
