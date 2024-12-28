<?php

namespace App\Http\ViewComposers;

use App\Repositories\ApplicationRepository;
use App\Repositories\MyAccountRepository;
use Illuminate\View\View;

class AppViewComposer
{
    protected ApplicationRepository $applicationRepository;
    protected MyAccountRepository $myAccountRepository;

    public function __construct(ApplicationRepository $applicationRepository, MyAccountRepository $myAccountRepository)
    {
        $this->applicationRepository = $applicationRepository;
        $this->myAccountRepository = $myAccountRepository;
    }

    public function compose(View $view): void
    {
        $view->with('application', $this->applicationRepository->getApplication());

        if (auth()->check()) {
            $view->with('myAccount', $this->myAccountRepository->myAccount());
        }
    }
}
