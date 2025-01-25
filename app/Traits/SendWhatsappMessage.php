<?php

namespace App\Traits;

use App\Models\WhatsappConfig;
use Illuminate\Support\Facades\Log;

trait SendWhatsappMessage
{
    protected function sendWhatsappMessage($textMessage): void
    {
        $whatsappApi = WhatsappConfig::active()->first();

        if (!$whatsappApi) {
            Log::error('WhatsApp API configuration not found.');
            return;
        }

        $curl = curl_init();
        $payload = [
            "data" => [$textMessage]
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: $whatsappApi->api_key", "Content-Type: application/json"));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_URL, $whatsappApi->domain);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_exec($curl);
        curl_close($curl);
    }
}
