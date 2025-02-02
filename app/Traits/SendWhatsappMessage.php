<?php

namespace App\Traits;

use App\Models\WhatsappConfig;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
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

        // TODO WABLAS
        if ($whatsappApi->provider === 'WABLAS') {
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

        // TODO WANESIA
        if ($whatsappApi->provider == 'WANESIA') {
            (new Client())->sendAsync(new Request('POST', $whatsappApi->domain), [
                'form_params' => [
                    'token' => $whatsappApi->api_key,
                    'number' => $textMessage['phone'],
                    'message' => $textMessage['message'],
                ]
            ])->wait();
        }
    }
}
