<?php

namespace App\Traits;

use App\Models\Application;
use App\Models\MessageTemplate;

trait MessageTrait
{
    protected function app(): Application
    {
        return Application::firstOrFail();
    }

    protected function message(): ?MessageTemplate
    {
        return MessageTemplate::filterByCategory('verifikasi_email')
            ->filterByRecipient('all')
            ->active()
            ->first();
    }
}
