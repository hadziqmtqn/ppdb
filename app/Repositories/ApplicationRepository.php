<?php

namespace App\Repositories;

use App\Models\Application;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ApplicationRepository
{
    protected Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function getApplication(): Collection
    {
        $application = $this->application
            ->firstOrFail();

        return collect([
            'name' => $application->name,
            'description' => $application->description,
            'website' => $application->website,
            'mainWebsite' => $application->main_website,
            'registerVerification' => $application->register_verification,
            'notificationMethod' => $application->notification_method,
            'logo' => $application->hasMedia('logo') ? $application->getFirstTemporaryUrl(Carbon::now()->addMinutes(5),'logo') : asset('assets/sekolah.png'),
        ]);
    }
}
