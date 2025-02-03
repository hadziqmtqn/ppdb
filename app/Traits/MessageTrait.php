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

    protected function message($category, $recipient, $educationalInstitutionId): ?MessageTemplate
    {
        return MessageTemplate::with('messageReceiver.user')
            ->where(function ($query) use ($category, $educationalInstitutionId) {
                $query->where(function ($query) use ($category) {
                    $query->filterByCategory($category)
                        ->whereNull('educational_institution_id');
                })
                    ->orWhere(function ($query) use ($category, $educationalInstitutionId) {
                        $query->filterByCategory($category)
                            ->educationalInstitutionId($educationalInstitutionId);
                    });
            })
            ->filterByRecipient($recipient)
            ->active()
            ->first();
    }
}
