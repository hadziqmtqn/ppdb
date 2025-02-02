<?php

namespace App\Repositories\SendMessage;

use App\Mail\SafetyChangesMail;
use App\Traits\MessageReplaceTrait;
use App\Traits\MessageTrait;
use App\Traits\SendWhatsappMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SafetyChangesRepository
{
    use SendWhatsappMessage, MessageTrait, MessageReplaceTrait;

    public function sendMessage(array $data): void
    {
        $placeholders = [
            "{nama_aplikasi}" => $this->app()->name,
            "{nama_pengguna}" => $data['username'],
            "{tanggal}" => Carbon::now()->isoFormat('DD MMM Y'),
            "{waktu}" => date('H:i:s'),
            "{kata_sandi_baru" => $data['password'],
            "{email_baru}" => $data['newEmail']
        ];

        if ($this->message('verifikasi_email', 'all')) {
            // notifikasi menggunakan email
            if ($this->app()->notification_method == 'email') {
                Mail::to($data['oldEmail'])
                    ->send(new SafetyChangesMail([
                        'message' => $this->replacePlaceholders($this->message('ubah_email_kata_sandi', 'all')->message, $placeholders)
                    ]));
            }

            // notifikasi menggunakan whatsapp
            if ($this->app()->notification_method == 'whatsapp') {
                $this->sendWhatsappMessage([
                    'phone' => $data['whatsappNumber'],
                    'message' => $this->replacePlaceholders($this->message('ubah_email_kata_sandi', 'all')->message, $placeholders)
                ]);
            }
        }
    }
}
