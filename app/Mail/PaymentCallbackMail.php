<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentCallbackMail extends Mailable
{
    use Queueable, SerializesModels;

    protected mixed $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), Application::first()->name),
            subject: 'Konfirmasi Pembayaran',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.payment-callback',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
