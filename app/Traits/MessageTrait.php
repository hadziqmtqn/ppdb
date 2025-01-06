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

    protected function message($category, $recipient): ?MessageTemplate
    {
        return MessageTemplate::filterByCategory($category)
            ->filterByRecipient($recipient)
            ->active()
            ->first();
    }
}
