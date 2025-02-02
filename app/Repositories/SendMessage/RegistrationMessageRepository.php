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

    public function sendMessage(array $data): void
    {
        $placeholders = [
            "{lembaga}" => $data['educationalInstitution'],
            "{nama_aplikasi}" => $this->app()->name,
            "{nama}" => $data['name'],
            "{no_whatsapp}" => $data['whatsappNumber'],
            "{email}" => $data['email'],
            "{kata_sandi}" => $data['password'],
            "{tanggal_registrasi}" => Carbon::now()->isoFormat('DD MMM Y'),
            "{jalur_pendaftaran}" => $data['registrationPath']
        ];

        // TODO Base Message Template
        $adminMessage = $this->message('registrasi', 'admin');
        $userMessage = $this->message('registrasi', 'user');

        // TODO Admin Message
        if ($adminMessage) {
            if (($this->app()->notification_method == 'email') && optional($adminMessage)->messageReceiver) {
                Mail::to(optional(optional($adminMessage->messageReceiver)->user)->email)
                    ->send(new RegisterMail([
                        'message' => $this->replacePlaceholders($adminMessage->message, $placeholders)
                    ]));
            }

            if (($this->app()->notification_method == 'whatsapp') && optional(optional(optional($adminMessage->messageReceiver)->user)->admin)->whatsapp_number) {
                $this->sendWhatsappMessage([
                    'phone' => optional(optional(optional($adminMessage->messageReceiver)->user)->admin)->whatsapp_number,
                    'message' => $this->replacePlaceholders($adminMessage->message, $placeholders)
                ]);
            }
        }

        // TODO User Message
        if ($userMessage) {
            if (($this->app()->notification_method == 'email') && $data['email']) {
                Mail::to($data['email'])
                    ->send(new RegisterMail([
                        'message' => $this->replacePlaceholders($userMessage->message, $placeholders)
                    ]));
            }

            if (($this->app()->notification_method == 'whatsapp') && $data['whatsappNumber']) {
                $this->sendWhatsappMessage([
                    'phone' => $data['whatsappNumber'],
                    'message' => $this->replacePlaceholders($userMessage->message, $placeholders)
                ]);
            }
        }
    }
}
