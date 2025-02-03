<?php

namespace App\Repositories\SendMessage;

use App\Mail\AcceptanceRegistrationMail;
use App\Traits\MessageReplaceTrait;
use App\Traits\MessageTrait;
use App\Traits\SendWhatsappMessage;
use Illuminate\Support\Facades\Mail;

class AcceptanceRegistrationRepository
{
    use SendWhatsappMessage, MessageTrait, MessageReplaceTrait;

    public function sendMessage(array $data): void
    {
        $placeholders = [
            "{nama}" => $data['username'],
            "{lembaga}" => $data['educationalInstitution'],
            "{website}" => $data['website']
        ];

        // TODO Registration accepted
        if ($data['registrationStatus'] == 'diterima') {
            if ($this->message('pendaftaran_diterima', 'user', $data['educationalInstitutionId'])) {
                // notifikasi menggunakan email
                if ($this->app()->notification_method == 'email') {
                    $this->toMail($data['email'], $this->replacePlaceholders($this->message('pendaftaran_diterima', 'user', $data['educationalInstitutionId'])->message, $placeholders));
                }

                // notifikasi menggunakan whatsapp
                if ($this->app()->notification_method == 'whatsapp') {
                    $this->toWhatsapp($data['phone'], $this->replacePlaceholders($this->message('pendaftaran_diterima', 'user', $data['educationalInstitutionId'])->message, $placeholders));
                }
            }
        }

        // TODO Registration rejected
        if ($data['registrationStatus'] == 'ditolak') {
            if ($this->message('pendaftaran_ditolak', 'user', $data['educationalInstitutionId'])) {
                // notifikasi menggunakan email
                if ($this->app()->notification_method == 'email') {
                    $this->toMail($data['email'], $this->replacePlaceholders($this->message('pendaftaran_ditolak', 'user', $data['educationalInstitutionId'])->message, $placeholders));
                }

                // notifikasi menggunakan whatsapp
                if ($this->app()->notification_method == 'whatsapp') {
                    $this->toWhatsapp($data['phone'], $this->replacePlaceholders($this->message('pendaftaran_ditolak', 'user', $data['educationalInstitutionId'])->message, $placeholders));
                }
            }
        }
    }

    private function toMail($email, $message): void
    {
        Mail::to($email)
            ->send(new AcceptanceRegistrationMail([
                'message' => $message
            ]));
    }

    private function toWhatsapp($phone, $message): void
    {
        $this->sendWhatsappMessage([
            'phone' => $phone,
            'message' => $message
        ]);
    }
}
