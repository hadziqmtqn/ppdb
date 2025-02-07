<?php

namespace App\Repositories\SendMessage;

use App\Mail\PaymentBillMail;
use App\Traits\MessageReplaceTrait;
use App\Traits\MessageTrait;
use App\Traits\SendWhatsappMessage;
use Illuminate\Support\Facades\Mail;

class PaymentBillRepository
{
    use SendWhatsappMessage, MessageTrait, MessageReplaceTrait;

    public function sendMessage(array $data): void
    {
        $placeholders = [
            "{nama}" => $data['name'],
            "{lembaga}" => $data['educationalInstitution'],
            "{nomor_tagihan}" => $data['invoinceNumber'],
            "{batas_waktu_pembayaran}" => $data['paymentDeadline'],
            "{instruksi_pembayaran}" => $data['paymentInstruction']
        ];

        if ($this->message('tagihan_pembayaran', 'user', null)) {
            // notifikasi menggunakan email
            if ($this->app()->notification_method == 'email') {
                Mail::to($data['email'])
                    ->send(new PaymentBillMail([
                        'message' => $this->replacePlaceholders($this->message('tagihan_pembayaran', 'user', null)->message, $placeholders)
                    ]));
            }

            // notifikasi menggunakan whatsapp
            if ($this->app()->notification_method == 'whatsapp') {
                $this->sendWhatsappMessage([
                    'phone' => $data['phone'],
                    'message' => $this->replacePlaceholders($this->message('tagihan_pembayaran', 'user', null)->message, $placeholders)
                ]);
            }
        }
    }
}
