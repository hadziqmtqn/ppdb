<?php

namespace App\Repositories\SendMessage;

use App\Mail\EmailChangeMail;
use App\Models\Application;
use App\Models\MessageTemplate;
use App\Models\WhatsappConfig;
use Illuminate\Support\Facades\Mail;

class EmailChangeRepository
{
    protected Application $application;
    protected MessageTemplate $messageTemplate;
    protected WhatsappConfig $whatsappConfig;

    public function __construct(Application $application, MessageTemplate $messageTemplate, WhatsappConfig $whatsappConfig)
    {
        $this->application = $application;
        $this->messageTemplate = $messageTemplate;
        $this->whatsappConfig = $whatsappConfig;
    }

    protected function app(): Application
    {
        return $this->application->firstOrFail();
    }

    protected function message(): ?MessageTemplate
    {
        return $this->messageTemplate->filterByCategory('verifikasi_email')
            ->filterByRecipient('all')
            ->active()
            ->first();
    }

    public function sendMessage($newEmail, $token, $phone): void
    {
        if ($this->message()) {
            // notifikasi menggunakan email
            if ($this->app()->notification_method == 'email') {
                Mail::to($newEmail)
                    ->send(new EmailChangeMail([
                        'message' => $this->replacingMessage($this->message()->message, $newEmail, $token)
                    ]));
            }

            // notifikasi menggunakan whatsapp
            if ($this->app()->notification_method == 'whatsapp') {
                $this->sendWhatsappMessage([
                    'phone' => $phone,
                    'message' => $this->replacingMessage($this->message()->message, $newEmail, $token)
                ]);
            }
        }
    }

    protected function replacingMessage($message, $newEmail, $token): array|string
    {
        return str_replace([
            "{nama_aplikasi}",
            "{metode_pengiriman}",
            "{email_baru}",
            "{tautan}"
        ], [
            $this->app()->name,
            $this->app()->notification_method,
            $newEmail,
            route('email-change.verification', ['token' => $token])
        ], $message);
    }

    protected function sendWhatsappMessage($textMessage): void
    {
        $whatsappApi = $this->whatsappConfig
            ->active()
            ->firstOrFail();

        if ($whatsappApi) {
            $curl = curl_init();
            $payload = [
                "data" => [$textMessage]
            ];

            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: $whatsappApi->api_key", "Content-Type: application/json"));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($curl, CURLOPT_URL, $whatsappApi->domain."/api/v2/send-message");
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_close($curl);
            curl_exec($curl);
        }
    }
}
