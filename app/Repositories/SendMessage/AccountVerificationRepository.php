<?php

namespace App\Repositories\SendMessage;

use App\Mail\AccountVerificationMail;
use App\Traits\MessageReplaceTrait;
use App\Traits\MessageTrait;
use App\Traits\SendWhatsappMessage;
use Illuminate\Support\Facades\Mail;

class AccountVerificationRepository
{
    use SendWhatsappMessage, MessageTrait, MessageReplaceTrait;

    public function sendMessage($email, $link, $phone): void
    {
        $placeholders = [
            "{nama_aplikasi}" => $this->app()->name,
            "{metode_pengiriman}" => $this->app()->notification_method,
            "{email_baru}" => $email,
            "{tautan}" => $link
        ];

        if ($this->message('verifikasi_email', 'all')) {
            // notifikasi menggunakan email
            if ($this->app()->notification_method == 'email') {
                Mail::to($email)
                    ->send(new AccountVerificationMail([
                        'message' => $this->replacePlaceholders($this->message('verifikasi_email', 'all')->message, $placeholders)
                    ]));
            }

            // notifikasi menggunakan whatsapp
            if ($this->app()->notification_method == 'whatsapp') {
                $this->sendWhatsappMessage([
                    'phone' => $phone,
                    'message' => $this->replacePlaceholders($this->message('verifikasi_email', 'all')->message, $placeholders)
                ]);
            }
        }
    }
}
