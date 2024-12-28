<?php

namespace App\Http\ViewComposers;

use App\Repositories\ApplicationRepository;
use Illuminate\View\View;

class AppViewComposer
{
    protected ApplicationRepository $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    public function compose(View $view): void
    {
        $view->with('application', $this->applicationRepository->getApplication());
    }
}
