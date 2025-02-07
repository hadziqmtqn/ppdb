<?php

namespace App\Repositories\SendMessage;

use App\Mail\PaymentCallbackMail;
use App\Models\Payment;
use App\Traits\MessageReplaceTrait;
use App\Traits\MessageTrait;
use App\Traits\SendWhatsappMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class PaymentCallbackRepository
{
    use SendWhatsappMessage, MessageTrait, MessageReplaceTrait;

    // TODO Success response
    public function success(Payment $payment): void
    {
        $placeholders = [
            "{nama}" => optional($payment->user)->name,
            "{lembaga}" => optional(optional(optional($payment->user)->student)->educationalInstitution)->name,
            "{nomor_tagihan}" => $payment->code,
            "{tanggal_pembayaran}" => Carbon::parse($payment->paid_at)->timezone('Asia/Jakarta')->isoFormat('DD MMM Y H:i'),
            "{metode_pembayaran}" => $payment->payment_method
        ];

        $this->sendMessage([
            'email' => optional($payment->user)->email,
            'phone' => optional(optional($payment->user)->student)->whatsapp_number,
            'message' => $this->replacePlaceholders($this->message('pembayaran_sukses', 'user', null)->message, $placeholders)
        ]);
    }

    // TODO Cancel response
    public function cancel(Payment $payment): void
    {
        $message = "Halo [Nama Siswa]!\n\n";
        $message .= "Maaf, pembayaran Anda untuk tagihan [Nomor Tagihan] gagal. Silakan coba lagi atau gunakan metode pembayaran lain.\n\n";
        $message .= "Jika Anda mengalami kesulitan atau memiliki pertanyaan, jangan ragu untuk menghubungi kami.\n\n";
        $message .= "[Nama Sekolah]\n\n";
        $message .= "_*PESAN INI TIDAK UNTUK DIHAPUS*_";

        $placeholders = [
            "[Nama Siswa]" => optional($payment->user)->name,
            "[Nama Sekolah]" => optional(optional(optional($payment->user)->student)->educationalInstitution)->name,
            "[Nomor Tagihan]" => $payment->code,
        ];

        $this->sendMessage([
            'email' => optional($payment->user)->email,
            'phone' => optional(optional($payment->user)->student)->whatsapp_number,
            'message' => $this->replacePlaceholders($message, $placeholders)
        ]);
    }

    private function sendMessage(array $data): void
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
