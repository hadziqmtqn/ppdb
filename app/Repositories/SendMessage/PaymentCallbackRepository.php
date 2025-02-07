<?php

namespace App\Repositories\SendMessage;

use App\Mail\PaymentCallbackMail;
use App\Traits\MessageReplaceTrait;
use App\Traits\MessageTrait;
use App\Traits\SendWhatsappMessage;
use Illuminate\Support\Facades\Mail;

class PaymentCallbackRepository
{
    use SendWhatsappMessage, MessageTrait, MessageReplaceTrait;

    public function sendMessage(array $data): void
    {
        if ($this->app()->notification_method == 'email') {
            Mail::to($data['email'])
                ->send(new PaymentCallbackMail([
                    'message' => $data['message']
                ]));
        }

        // notifikasi menggunakan whatsapp
        if ($this->app()->notification_method == 'whatsapp') {
            $this->sendWhatsappMessage([
                'phone' => $data['phone'],
                'message' => $data['message']
            ]);
        }
    }
}
