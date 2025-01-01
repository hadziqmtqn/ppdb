<?php

namespace App\Repositories\SendMessage;

use App\Mail\EmailChangeMail;
use App\Models\Application;
use App\Models\MessageTemplate;
use Illuminate\Support\Facades\Mail;

class EmailChangeRepository
{
    protected Application $application;
    protected MessageTemplate $messageTemplate;

    public function __construct(Application $application, MessageTemplate $messageTemplate)
    {
        $this->application = $application;
        $this->messageTemplate = $messageTemplate;
    }

    private function app(): Application
    {
        return $this->application->firstOrFail();
    }

    private function message(): ?MessageTemplate
    {
        return $this->messageTemplate->filterByCategory('verifikasi_email')
            ->filterByRecipient('all')
            ->active()
            ->first();
    }

    public function sendMessage($newEmail, $token): void
    {
        if ($this->app()->notification_method == 'email') {
            $this->mailMethod($newEmail, $token);
        }
    }

    private function mailMethod($newEmail, $token): void
    {
        if ($this->message()) {
            Mail::to($newEmail)
                ->send(new EmailChangeMail([
                    'message' => str_replace([
                        "{nama_aplikasi}",
                        "{metode_pengiriman}",
                        "{email_baru}",
                        "{tautan}"
                    ], [
                        $this->app()->name,
                        $this->app()->notification_method,
                        $newEmail,
                        route('email-change.verification', $token)
                    ], $this->message()->message)
                ]));
        }
    }
}
