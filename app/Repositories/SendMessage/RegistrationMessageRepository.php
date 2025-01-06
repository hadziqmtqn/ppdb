<?php

namespace App\Repositories\SendMessage;

use App\Mail\RegisterMail;
use App\Traits\MessageReplaceTrait;
use App\Traits\MessageTrait;
use App\Traits\SendWhatsappMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class RegistrationMessageRepository
{
    use SendWhatsappMessage, MessageTrait, MessageReplaceTrait;

    public function __construct()
    {
    }

    public function sendMessage($data): void
    {
        $placeholders = [
            "lembaga" => $data['educationalInstitution'],
            "{nama_aplikasi}" => $this->app()->name,
            "{nama}" => $data['name'],
            "{no_whatsapp}" => $data['whatsappNumber'],
            "{email}" => $data['email'],
            "{kata_sandi}" => $data['password'],
            "{tanggal_registrasi}" => Carbon::now()->isoFormat('DD MMM Y'),
            "{jalur_pendaftaran}" => $data['registrationPath']
        ];

        if ($this->message('registrasi', 'admin')) {
            $this->processingMessages('registrasi', 'admin', $data, $placeholders);
        }

        if ($this->message('registrasi', 'user')) {
            $this->processingMessages('registrasi', 'user', $data, $placeholders);
        }
    }

    protected function processingMessages($category, $recipient, $data, $placeholders): void
    {
        // TODO Email
        if ($this->app()->notification_method == 'email') {
            Mail::to($data['email'])
                ->send(new RegisterMail([
                    'message' => $this->replacePlaceholders($this->message($category, $recipient)->message, $placeholders)
                ]));
        }

        // TODO Whatsapp
        if ($this->app()->notification_method == 'whatsapp') {
            $this->sendWhatsappMessage([
                'phone' => $data['whatsapp_number'],
                'message' => $this->replacePlaceholders($this->message($category, $recipient)->message, $placeholders)
            ]);
        }
    }
}
