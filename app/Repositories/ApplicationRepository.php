<?php

namespace App\Repositories;

use App\Models\Application;

class ApplicationRepository
{
    protected Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function getApplication(): Application
    {
        return $this->application
            ->firstOrFail();
    }
}
