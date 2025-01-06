<?php

namespace App\Repositories\SendMessage;

use App\Mail\EmailChangeMail;
use App\Models\Application;
use App\Models\MessageTemplate;
use App\Traits\MessageReplaceTrait;
use App\Traits\MessageTrait;
use App\Traits\SendWhatsappMessage;
use Illuminate\Support\Facades\Mail;

class EmailChangeRepository
{
    use SendWhatsappMessage, MessageTrait, MessageReplaceTrait;

    protected Application $application;
    protected MessageTemplate $messageTemplate;

    public function __construct(Application $application, MessageTemplate $messageTemplate)
    {
        $this->application = $application;
        $this->messageTemplate = $messageTemplate;
    }

    public function sendMessage($newEmail, $token, $phone): void
    {
        if ($this->message()) {
            $placeholders = [
                "{nama_aplikasi}" => $this->app()->name,
                "{metode_pengiriman}" => $this->app()->notification_method,
                "{email_baru}" => $newEmail,
                "{tautan}" => route('email-change.verification', ['token' => $token])
            ];

            // notifikasi menggunakan email
            if ($this->app()->notification_method == 'email') {
                Mail::to($newEmail)
                    ->send(new EmailChangeMail([
                        'message' => $this->replacePlaceholders($this->message()->message, $placeholders)
                    ]));
            }

            // notifikasi menggunakan whatsapp
            if ($this->app()->notification_method == 'whatsapp') {
                $this->sendWhatsappMessage([
                    'phone' => $phone,
                    'message' => $this->replacePlaceholders($this->message()->message, $placeholders)
                ]);
            }
        }
    }
}
